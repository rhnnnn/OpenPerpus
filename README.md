<h1 align="center">AKU Project</h1>

## Introduction
<p align="justify">
You may wonder, what the hell is AKU stands for, well it stands for
nothing, we just can't explain it because its an inside jokes. it took 12 years of internet exploration to understand this term.

<p align="justify">

</p>
</p>


## You may ask what the hell is this
<p align="justify">
    Made by two teenagers who have only learned 5 days worth of laravel before starting this project. It's a basic Laravel CRUD with quite the features.
    <p align="justify">
    This project can handle CRUD operations through random methods, some use ajax, some I dont even know how I made it but it works.
    </p>
    <p align="justify">
    The tables support sorting, pagination, or search data on the table, and you also could import and export the table as excel files.
    </p>
</p>


## Before Installing This Project

<p align="justify">
    You need to make sure that you're using PHP 8.1 for the minimum version, then you will need to install some other tools like, Git for cloning this project into your local server directory, Composer for managing php package and installing some others package that will be needed. Also, you should make sure that you have enabled the following php extension in php.ini configuration file, such as:
</p>

- php_zip
- php_xml
- php_gd2
- php_iconv
- php_simplexml
- php_xmlreader
- php_zlib

## Installation Instruction

1. Clone this project and `cd` into the cloned project by using this following this command:
   
   ```shell
    git clone https://github.com/viernism/aku_crud.git && cd aku_crud
   ```

2. After that, you'll need to copy `.env.example` into `.env` file and installing components from `composer` by using this following command:

    ```shell
    cp .env.example .env && composer install
    ```

3. Now, after that installing components from `composer` completed, you need to generate key by using this following command:
   
   ```bash
    php artisan key:generate
   ```

4. Now, you will need to set up your database. It's better to use database engine like PostgreSQL or MySQL. You can change it on your `.env` file, for example we are using MySQL. then, you can configure it like this, but remember to configure it based on your server settings.

    <img src="https://raw.githubusercontent.com/rhnnnn/mulmed-sheet/main/Screenshot_20230417_103526.png">


5. Before migrating the tables, you will need to set up an admin user in user seeder


6. Run this following command to migrate all needed table.
   
   ```bash
   php artisan migrate --seed
   ```


7. Don't forget to run this command, so the profile picture upload and other things can work.

    ```bash
    php artisan storage:link
    ```

8. And, you can log in using several default accounts below:

    
        **Admin User**
        ---
        - email     : admin@crud.test
        - password  : 4dM1nistrat0r

        **Basic User**
        ---
        - email     : testuser@crud.test
        - password  : !mT35tUs3R