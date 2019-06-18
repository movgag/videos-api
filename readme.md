## Installation after cloning the project

* composer install
* create .env file according to .env.example file in the root of the project
* setup the database (mysql)
* php artisan migrate
* php artisan db:seed

## Unit testing via PhpUnit (sqlite)

* ./vendor/bin/phpunit

## Api routes

* GET ; /videos/size/{username} ; {username} - string | required
* GET ; /videos/metadata/{id} ; {id} - integer | required
* PATCH ; /videos ;  id - integer | requried  
                     file_size - integer | required | integer or float (with 2 decimals)
                     viewers_count - integer | requried 
