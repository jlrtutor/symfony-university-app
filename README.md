# Symfony 4 University App

University application made in Symfony 4

## How to install and run

```
$ git clone https://github.com/jlrtutor/symfony-university-app.git
$ cd symfony-university-app
$ composer install
```
> Configure database params

Edit /.env line 27 and change database credentials if needed:
```
DATABASE_URL=mysql://root:@127.0.0.1:3306/symfony-university <- user: root, no password, database name `symfony-university`
```

> Then, create database
```
$ php bin/console doctrine:database:create
```

> Create Schema
```
$ php bin/console doctrine:schema:create
```

> Loading Fixtures
```
$ php bin/console doctrine:fixtures:load
```

> Run local server
```
$ php bin/console server:run
```

> Open your brownser and Log in
```
Email: admin@admin.com
Password: admin
```

# And enjoy!
