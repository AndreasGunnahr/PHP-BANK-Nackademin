# php-api-bank

PHP course - Exercise 3 Bank application with transactions API and login.

# Exercise 3 - Bank application with transaction API and login

PHP course - Exercise 3 in our school course.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
Install PHP and possibly some type of server/apache (MAMP or XAMPP) to run the application.
```

```
You will need [Composer](https://getcomposer.org/) to install .env support
```

### Installing

A step by step series of examples that tell you how to get a development env running

```
Git clone https://github.com/AndreasGunnahr/php-api-bank.git
```

```
cd App (change path to folder App) and create a .env file
```

```
Add following structure:
DB_HOST=YOUR_HOSTNAME
DB_USER=YOUR_USERNAME
DB_PASS=YOUR_PASSWORD
DB_DATABASE=YOUR_DATABASE
```

```
Then add support for the .env file with following command:
composer require --dev phpdotenv
```

```
You are now ready to run your application!
```

## Built With

- [PHP](https://www.php.net/) - Used for both mostly backend development
- [Javascript](https://www.javascript.com/) - Used for Ajax calls to our API
- [Composer](https://getcomposer.org/) - Used to handle .env support in PHP
  \* [Bootstrap](https://getbootstrap.com/) - Used for a fast and easy styling

## Authors

- **Andreas Gunnahr** - [Nackademin](https://github.com/AndreasGunnahr)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
