# Requirements
- PHP 8.1 or higher
- Composer
### Optional
- Symfony CLI (but very usefull)

For PHP extensions you can use the default ones required by symfony. You can check if your php installation meets all the requirements. Just run this command
```sh
symfony check:requirements
```

# Installation
First (after `git clone`) install all dependencies
```sh
composer install
```
The second step is to configure your .env.local. This file should contain everything that shouldn't be commited, such as secrets, database connection data etc.
```sh
# File: .env.local
# Database connection example

# to use mysql:
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"

# to use mariadb:
# DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=mariadb-10.5.8"

# to use sqlite:
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"

# to use postgresql:
# DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=11&charset=utf8"

# to use oracle:
# DATABASE_URL="oci8://db_user:db_password@127.0.0.1:1521/db_name"
```
Next step is to create database, and make migration to create all tables
```sh
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

To start server type
```sh
symfony server:start
```

You can now create first user (admin)
```sh
php bin/console app:create-user <email> <password>
```
For example
```sh
php bin/console app:create-user admi@mydomain.com MyCoolPassword
```