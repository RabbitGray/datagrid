
This was project was forked from 
====================================
Lazy Mofo (LM) PHP Datagrid
project home, demo and documentation: [http://lazymofo.wdschools.com/](http://lazymofo.wdschools.com/)
MIT License

LM is a single PHP5 class for performing CRUD (create, read, update and delete) operations on a MySQL database table.

-   Define grids and forms by SQL statements or table name
-   Populate select, radio, and checkbox inputs with data from SQL statements
-   Upload documents, resize or crop images
-   Grid features include pagination, sorting, and inline editing. Searching can be added.
-   Grid uses SQL_CALC_FOUND_ROWS, limit + offset for efficiency and low memory usage on large datasets
-   Built-in validation, error reported next to input
-   Lightweight; a single class====================================


This version focuses on: 
=========================
serving code snippets, document files, images and links. 
===================================================================================

Eventually there will be admin and users, to allow users to insert data but not remove it but for now everyone has control.


Installation Guide
=========================

Database Setup
=========================

MySQL Database setup:
    Login into PhpMyAdmin -> Import -> Browse you computer -> choose "database_setup.sql"

Copy Files
=========================
Copy these 4 files into you WWW directory.
   1. Index.php
   2. db_conn.php
   3. lazy_mofo.php
   4. style.ss

Configuration
=========================

Edit db_conn.php
on line 5 and 6 you should see

    $db_user = 'root';
    $db_pass = 'password';
    
change these to your MySQL login details.
