<?php

namespace App;

use Mail;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Util {

    private static $dateFormat = 'm/d/Y';
    private static $timeFormat = 'H:i:s';
    private static $dateTimeFormat = 'm/d/Y H:i:s';

    private static $operators = [
        'c' => 'like',
        'e' => '=',
        'g' => '>',
        'ge' => '>=',
        'l' => '<',
        'le' => '<='
    ];

    public static function getOperator($oper) {
        if (!isset(self::$operators[$oper])) {
            return '=';
        }
        return self::$operators[$oper];
    }

    public static function IsInvalidSearch($columns, $searchCol) {
        if ($searchCol == null) {
            return false;
        }
        foreach ($columns as $column) {
            if (strpos($column, $searchCol) === 0) {
                return false;
            }
        }
        return true;
    }

    public static function sentMail($type, $email, $token, $user = null) {
        $body = str_replace('{app_url}', env('APP_URL'), env("MAIL_$type"));
        $body = str_replace('{app_name}', env('APP_NAME'), $body);
        $body = str_replace('{token}', $token, $body);
        if ($user) {
            $body = str_replace('{user}', $user, $body);
        }
        $subject = ($type == 'WELCOME' ? 'Login Information' : ($type == 'RESET' ? 'Reset Password' : env('APP_NAME') . ' message'));
        /* You need to complete the SMTP Server configuration before you can sent mail
        Mail::raw($body, function ($message) use($type, $email, $subject) {
            $message->from(env('MAIL_SENDER'))->to($email)->subject($subject);
        });
        */
    }

    public static function setRef() {
        request()->session()->flash('ref', request()->query->get('ref'));
    }

    public static function getRef($path) {
        $ref = $path;
        if (request()->session()->has('ref')) { //original request will not available when validation failed
            $ref = request()->session()->get('ref');
            request()->session()->forget('ref');
        }
        else if (request()->query->get('ref')) {
            $ref = request()->query->get('ref');
        }
        else if (request()->headers->get('referer') && request()->headers->get('referer') != request()->url() && !request()->query->get('back')) {
            $ref = request()->headers->get('referer');
        }
        if (strpos($ref, 'back=1') === false) {
            $ref .= (strpos($ref, '?') !== false ? '&' : '?') . 'back=1';
        }
        return $ref;
    }

    public static function getFile($path, $file) { //need to run "php artisan storage:link" command to access uploaded file from URL "/storage/path/filename"
        if ($file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $path . '/' . $filename;
            while (Storage::disk('public')->exists($filePath)) {
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = $path . '/' . $filename;
            }
            if (Storage::disk('public')->put($filePath, file_get_contents($file))) {
                return $filename;
            }
        }
    } 

    public static function getRaw($value) {
        return $value == '' ? $value : DB::raw($value); //empty('0') is true
    }

    public static function formatDate($value) {
        return $value == '' ? $value : date(self::$dateFormat, strtotime($value));
    }

    public static function formatTime($value) {
        return $value == '' ? $value : date(self::$timeFormat, strtotime($value));
    }

    public static function formatDateTime($value) {
        return $value == '' ? $value : date(self::$dateTimeFormat, strtotime($value));
    }

    public static function getDate($value) {
        return $value == '' ? $value : self::createDate(self::$dateFormat, $value);
    }

    public static function getTime($value) {
        return $value == '' ? $value : self::createDate(self::$timeFormat, $value);
    }

    public static function getDateTime($value) {
        return $value == '' ? $value : self::createDate(self::$dateTimeFormat, $value);
    }

    public static function formatDateStr($value, $type) {
        if ($type == 'time') {
            return self::getTime($value)->format('H:i:s');
        }
        else if ($type == 'date') {
            return self::getDate($value)->format('Y-m-d');
        }
        else {
            return self::getDateTime($value)->format('Y-m-d H:i:s');
        }
    }

    private static function createDate($format, $value) {
        $date = DateTime::createFromFormat($format, $value);
        if ($date === false) {
            throw new \Exception("'$value' is invalid format of '$format'");
        }
        return $date;
    }
}