# xkamen06/pms - Project Management System (web information system)

## Instalace

Nakopírovat repozitář (xkamen06/pms) do složky `workbench` v kořenovém adresáři
laravel projetu (pokud neexistuje složka `workbench`, pak je nutné ji vytvořit)

Do `config/app.php` přidat 

     'providers' => [
        \xkamen06\pms\PMSServiceProvider::class,
     ];

Do `composer.json` přidat 
     
     "autoload": {
            "classmap": [
                "workbench"
            ],
        },
       
Spustit následující příkaz 
       
       composer update
   
   
### Pro vytvoření databáze 

Vyplnit databázové údaje v souboru `.env` napřklad takto

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=PMS_Database
    DB_USERNAME=root
    DB_PASSWORD=

Odebrat migrace z adresáře `/database/migrations`

Spustit příkaz 
    
    php artisan migrate
    
##### Pro vytvoreni testovacich zaznamu v databazi 

Do `/database/seeds/DatabaseSeeder.php` do metody `run()` přidat 

    $this->call(PMSDataSeeder::class); 

Spustit příkaz 
    
    php artisan db:seed

#### Styly 

Spustit příkaz 

    php artisan vendor:publish
    
a zvolit možnost "0"    
    
A zveřejnit soubory co se týkají `xkamen06\pms\PMSServiceProvider`

Obsah `/webpack.mix.js` nahradit 

    mix.sass('resources/assets/sass/main.sass', 'public/css');

Spustit příkazy 

    npm install
    npm run dev 
    
    
#### Cachování 

Spustit příkaz 

    composer require predis/predis
    
Pokud chceme aby fungovalo cachování tak v `.env` nastavíme 

    APP_DEBUG=false

V opačném případě nebude cache fungovat.

Dále také nastavíme v `.env` 

    CACHE_DRIVER=redis

Pokud nastává chyba ....neco s connection tak spustíme redis v příkazové řádce

    redis-serve&

#### Debugbar
Debugbar funguje pouze v režimu debug, to jest 
    
        APP_DEBUG=true

Pokud chceme aby fungoval debugbar i při vyplém debugu tak do `.env` 
přidáme
 
    DEBUGBAR_ENABLED=true


#### Jazyky

Přidejte následující do `app/Http/Kernel.php` 

    protected $middlewareGroups = [
        'web' => [
                \xkamen06\pms\Middlewares\Language::class,
        ]
    ]

##### !!! Pozor - nutne pridat az za posledni middlewaru v poli web !!!

Pro pridani jazyku smazat `auth.php` ze slozky `\resources\lang\en\`

Spustit
 
    php artisan vendor:publish
     
