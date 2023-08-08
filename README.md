<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About Laravel

This app manages shopping product process. It is used to create products and collect products on package.
Those products have sizes, colors and prices details.
We can add those product to specific company and to specific closet on the company, and then we can create shipment for
recipient and manage products in warehouse. And also track the shipment of product / packages.
Also notify users and company members with email. 
and more ...

## Steps to run the app

- run ``composer install``
- run ``npm install``
- Configuration
    - create .env file and copy the config from .env.example file to .env
    - run ``php artisan key:generate``
    - Update APP_URL=https://laravel-vue.test
    - Configure your database at .env
        - run ``php artisan migrate:fresh --seed``
    - Configure your email at .env
- ``composer global require laravel/valet``
- run ``valet install``
- run ``valet link --secure``
- run ``npm run dev``

