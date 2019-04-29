# xkamen06/pms - Project Management System (web information system)

## Instalace (do čisté Laravel instalace)

Do souboru `composer.json` v aplikaci, do sekce (objektu) `require` přidat:

    "xkamen06/pms": "^1.0"
    
Spustit příkaz: 
       
    composer update
       
A nebo jednodušeji v hlavním adresáři aplikace spustit příkaz: 

    composer require xkamen06/pms      
   
### Vytvoření databáze 

Vyplnit databázové údaje v souboru `.env` např9klad takto (pokud tak ještě není učiněno):

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=PMS_Database
    DB_USERNAME=root
    DB_PASSWORD=root

Odebrat migrace z adresáře `/database/migrations`:

Spustit příkaz: 
    
    php artisan migrate
    
##### Pro vytvoření testovacích záznamů v databázi 

Do `/database/seeds/DatabaseSeeder.php` do metody `run()` přidat: 

    $this->call(PMSDataSeeder::class); 

Spustit příkaz: 
    
    php artisan db:seed

#### Routes

Zakomentovat obsah souboru `/routes/web.php`

#### Styly 

Spustit příkaz: 

    php artisan vendor:publish
    
a zvolit možnost "0"    
    
A tím zveřejnit soubory co se týkají `xkamen06\pms\PMSServiceProvider`

Obsah `/webpack.mix.js` nahradit: 

    mix.sass('resources/sass/main.sass', 'public/css');

Spustit příkazy: 

    npm install
    npm run dev 
    
#### Konfigurace 

Pro zveřejnění konfiguračních souborů spustit příkaz: 
(pokud již tak nebylo učiněno v přechozím kroce Styly)

    php artisan vendor:publish
    
a zvolit možnost "0"    
    
A tím zveřejnit soubory co se týkají `xkamen06\pms\PMSServiceProvider`

#### Cachování 
    
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

#### Překlady

Pro přidání jazyku smazat `auth.php` ze složky `\resources\lang\en\`
     