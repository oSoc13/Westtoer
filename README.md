# Westtoer
---

Web framework for Westtoer to retrieve, filter and serve data from the datahub.

## Features
* **Data fetcher**: Retrieves and caches data from the datahub.
* **Dashboard**: Control panel for users with screen(s) to customize their screens.
* **REST service**: Data source for the screen(s). Formats data from cache/data fetcher for screen(s) based on settings from dashboard. Compatible with [FlatTurtle](http://flatturtle.com)




## Developed and tested on

 * Apache
 * PHP 5.3.x with APC (caching)
 * MySQL

## Installation
### Prerequisites

This project uses Laravel 4 as base framework.
All dependencies are defined in ```composer.json``` can be installed using [composer](http://getcomposer.org/).
Install composer and run the ```composer install``` command in this project dir to fetch all libraries.

1. Install composer, see <http://getcomposer.org/> for more information.
2. Download the contents of this repo or clone it.
3. In the project folder run composer with the parameter ```install```, this will read the ```composer.json``` from the current directory and install all required libraries in the subdirectory ```vendor```.

```
	composer install
```
### Configuration

Laravel supports multiple environments for configuration. The base configuration files can be found in ```app/config```.

### Single configuration (one environment)

If you just want to configure this framework for one (production) server, just edit the files in ```app/config```.



#### /app/config/database.php

Adjust the ```connections``` array with the database server details.
##### example
```
	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'database_name',
			'username'  => 'database_username',
			'password'  => 'user_password',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => 'prefix_',
		)

	),
```

#### /app/config/cache.php

Adjust the ```driver``` value to select the desired caching method.

**Note** ```file``` does not support caching in sections and cannot be used.

##### example
```
'driver' => 'apc',
```


#### /app/config/hub.php

Add details for the datahub to fetch the data from.

* ```base_url``` : uri of the datahub
* ```user``` : username to connect to the datahub
* ```password```: password to connect to the datahub
* ```cache_ttl```: time to live for cached data fetched from the datahub.



##### example
```
return array(
	'base_url' => 'https://datahub.westtoer.be/',
	'user' => 'username',
	'password' => 'password',
	'cache_ttl' => 60*60
);
```

### Multiple environments

If you want to use multiple environments (for example: a development environment and a production environment with separate caching and databases). Copy the files to a new subdirectory in the ```/app/config``` folder and configure them there, for example in ```/app/config/development``` and in ```/app/config/production```.

Then configure the detection of the development environment in ```bootstrap/start.php```.

```
$env = $app->detectEnvironment(array(
    'development' => array('*.dev', 'localhost'),
    'production' => array('dashboard.westtoer.be'),

));
```

### Database migration

To create the necessary tables for this framework, ```artisan``` can be used.

In the project root, run:

```
php artisan migrate:refresh
```

If your using multiple environments, add the corresponding environment

```
php artisan --env=development migrate:refresh
```


