# sw-code-challenge
 A simple Content Management System (CMS) for educational articles

##Setup
The following prerequisites are required for this project:
* MySQL: v8.0.31
* node: v16.17.1
* php: v8.1.10
* composer v2.4.3

If there are issues with setup, please verify that you have these installed and that the version is up to date.
    
###Database Setup:

This project requires a MySQL database setup for storage of the Articles/Users. Set up a MySQL database by following the instructions [here](https://dev.mysql.com/doc/mysql-getting-started/en/).

###Frontend Setup:

1. Install Dependencies
```npm install```
2. Create .env using .env.example file and include api endpoint
Laravel defaults to port 8000, but if you configured your backend to run on a different port, update this variable accordingly.
```VITE_APP_API_ENDPOINT=http://localhost:8000/api```

3. Start development server for the frontend
```npm run dev```

###Backend Setup:


1. Install Dependencies
```composer install```
2. Create .env file using .env.example in backend folder
update the database configuration so that it is configured to your MySQL Database.
`DB_CONNECTION=mysql
DB_HOST={YOUR_HOST}
DB_PORT={YOUR_PORT}
DB_DATABASE={YOUR_DATABASE}
DB_USERNAME={YOUR_USERNAME}
DB_PASSWORD={YOUR_PASSWORD}
`
3. Migrate Database
```php artisan migrate:fresh```
4. Seed Database
```php artisan db:seed```
5. Start development Laravel server
```php artisan serve```


##Testing
For testing, the project uses an SQLite in-memory database. Ensure your .env.testing configuration matches your testing needs.

To run tests: 
```php artisan test```
