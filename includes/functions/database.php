<?php

$host = getenv("DB_HOSTNAME");
$port = "5432";
$databaseName = getenv("DB_NAME");
$username = getenv("DB_USERNAME");
$password = getenv("DB_PASSWORD");
$connectionString = "host=$host port=$port dbname=$databaseName user=$username password=$password";

// TODO: Complete with your code for the Database