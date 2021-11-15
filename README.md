# Project name

## Install info

* Copy the file `.env.example` to `.env` and make settings in it
* Run console command `composer install`
* Run console command `php artisan migrate`
* Run console command `php artisan db:seed`
* Run console command `php artisan storage:link`
* Add the task `* * * * * php /path/to/artisan schedule:run >> /dev/null` to cron, specifying the full path to the file `artisan` in the root directory of the project

## Local info

* Run console commands
    * `php artisan ide-helper:generate`
    * `php artisan ide-helper:meta`

## Version info

* PHP 8.0
* MySQL 8
* Laravel 8.70
