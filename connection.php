<?php
$driver = 'pgsql';
$database = 'tm_test';
$username = 'postgres';
$password = 'admin';
$host = '127.0.0.1';
$port = 5432;

// Create connection
$connection = pg_connect("host=$host dbname=$database user=$username password=$password port=$port");
