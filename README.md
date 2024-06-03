# Boilerplate-CRUD-Laravel-11
Boilerplate CRUD Web App created with Laravel 11 by [StackPuz](https://stackpuz.com).

## Demo
Checkout the live demo at https://demo.stackpuz.com

## Features
- Fully Responsive Layout.
- Sorting, Filtering and Pagination on Data List.
- User Management, User Authentication and Authorization, User Profile, Reset Password.
- Input Mask and Date Picker for date and time input field with Form Validation and CSRF Protection.

![Responsive Layout](https://stackpuz.com/img/feature/responsive.gif)  
![Data List](https://stackpuz.com/img/feature/list.gif)  
![User Module](https://stackpuz.com/img/feature/user.png)  
![Input Mask and Date Picker](https://stackpuz.com/img/feature/date.gif)

## Minimum requirements
- Composer 2.2
- PHP 8.2
- MySQL 5.7

## Installation
1. Clone this repository. `git clone https://github.com/stackpuz/Boilerplate-CRUD-Laravel-11.git .`
2. Install the dependencies. `composer install`
3. Create the symbolic link. `php artisan storage:link`
4. Create a new database and run [/database.sql](/database.sql) script to create tables and import data.
5. Edit the database configuration in [/.env](/.env) file.
    ```
    DB_CONNECTION=mysql
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=testdb
    DB_USERNAME=root
    DB_PASSWORD=
    ```

## Run project

1. Run Laravel project. `php artisan serve`
2. Navigate to `http://localhost:8000`
3. Login with user `admin` password `1234`

## Customization
To customize this project to use other Database Engines, CSS Frameworks, Icons, Input Mask, Date picker, Date format, Font and more. Please visit [stackpuz.com](https://stackpuz.com).

## License

[MIT](https://opensource.org/licenses/MIT)