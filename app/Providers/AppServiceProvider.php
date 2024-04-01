<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app['router']->aliasMiddleware('role' , \App\Http\Middleware\HasRole::class);
        Blade::directive('getLink', function ($exp) {
            $arr = explode(',', $exp);
            $sort = sizeof($arr) > 3 ? $arr[3] : '';
            if ($arr[0] == 'sort') {
                $link = "'?page='.\${$arr[1]}->currentPage().'&size='.\${$arr[1]}->perPage().'&sort=$arr[2]'.(((isset(\$_REQUEST['sort']) && \$_REQUEST['sort'] == '$arr[2]') || (!isset(\$_REQUEST['sort']) && '$sort' == 'asc')) && !isset(\$_REQUEST['desc']) ? '&desc=1' : '')";
            }
            else if ($arr[0] == 'page') {
                $link = "'?page='.({$arr[2]}).'&size='.\${$arr[1]}->perPage().(isset(\$_REQUEST['sort']) ? '&sort='.\$_REQUEST['sort'].(isset(\$_REQUEST['desc']) ? '&desc=1' : '') : '')";
            }
            else if ($arr[0] == 'size') {
                $link = "'?page=1&size=$arr[2]'.(isset(\$_REQUEST['sort']) ? '&sort='.\$_REQUEST['sort'].(isset(\$_REQUEST['desc']) ? '&desc=1' : '') : '')";
            }
            $link .= ".(isset(\$_REQUEST['sw']) ? '&sw='.\$_REQUEST['sw'].'&sc='.\$_REQUEST['sc'].'&so='.\$_REQUEST['so'] : '')";
            return "<?php echo $link ?>";
        });
        Blade::directive('getSortClass', function ($exp) {
            $arr = explode(',', $exp);
            $column = $arr[0];
            $sort = sizeof($arr) > 1 ? $arr[1] : '';
            $class = "((isset(\$_REQUEST['sort']) && \$_REQUEST['sort'] == '$column') || (!isset(\$_REQUEST['sort']) && '$sort') ? (isset(\$_REQUEST['sort']) ? (isset(\$_REQUEST['desc']) ? 'sort desc' : 'sort asc') : 'sort $sort') : 'sort')";
            return "<?php echo $class ?>";
        });
    }
}