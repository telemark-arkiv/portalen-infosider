<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */
 
$conf = [
    "mysql_database" 	=> getenv('MYSQL_DATABASE'),
    "mysql_user" 		=> getenv('MYSQL_USER'),
    "mysql_password" 	=> getenv('MYSQL_PASSWORD'),
    "mysql_host" 		=> getenv('MYSQL_HOST')
];

return array(

	// The database server name or IP address. Usually this is 'localhost' or '127.0.0.1'.
	'server' => $conf['mysql_host'],

	// The name of the database to select.
	'database' => $conf['mysql_database'],

	// The database username to connect with.
	'user' => $conf['mysql_user'],

	// The database password to connect with.
	'password' => $conf['mysql_password'],

	// The prefix to use when naming tables. This can be no more than 5 characters.
	'tablePrefix' => 'craft',

);
