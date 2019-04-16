# xkamen06/pms - Project Management System (web information system)

## Installation

Copy the rpository with xkamen06/pms to folder `workbench` in root directory of 
new laravel project (maybe you have to create folder workbench)


To `config/app.php` add 

     'providers' => [
        \xkamen06\pms\PMSServiceProvider::class,
     ];

To `composer.json` add 
     
     "autoload": {
            "classmap": [
                "workbench"
            ],
        },
            
Run following command            
    
    composer update
    
### To create a database

Fill data to `.env` file for exapmle like this

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=PMS_Database
    DB_USERNAME=root
    DB_PASSWORD=

Delete migrations from directiory `/database/migrations` 

Run following command
    
    php artisan migrate
    
##### To create demo data in database

In `/database/seeds/DatabaseSeeder.php` to method `run()` add 

    $this->call(PMSDataSeeder::class); 

Run following command
    
    php artisan db:seed
    
    
#### Styles 

Run following command

    php artisan vendor:publish
    
select option "0"    
    
Publish files for
`xkamen06\pms\PMSServiceProvider`

Content of `/webpack.mix.js` replace by

    mix.sass('resources/assets/sass/main.sass', 'public/css');

Run following commands

    npm install
    npm run dev 
    
    
#### Cache

Run following command

    composer require predis/predis

For using cache, in file `.env` set

    APP_DEBUG=false

else you can't use caching 

After thaht set in file `.env`

    CACHE_DRIVER=redis

If there is error ...with connection, than run redis in command line 

    redis-serve&

#### Debugbar

Debugbar works only in debug
    
        APP_DEBUG=true

If we want to use debugbar while there is not debug we want to add to file `.env` 
following
 
    DEBUGBAR_ENABLED=true


#### Languages

Add following `app/Http/Kernel.php` to

    protected $middlewareGroups = [
        'web' => [
                \xkamen06\pms\Middlewares\Language::class,
        ]
    ]

##### !!! Be careful it has to be in field after last middleware !!!

For adding languages delete `auth.php` from folder `\resources\lang\en\`

Run
 
    php artisan vendor:publish
     
     
