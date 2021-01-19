<?php

print getenv("MYSQL_DATABASE");


// %s for string and %d for numbers
$connection = new PDO(
    sprintf(
        "mysql:host=%s;port=%d;dbname=%s",
        getenv("HOSTNAME"),
        3306,
        getenv("MYSQL_DATABASE")
    ),
    getenv("MYSQL_USER"),
    getenv("MYSQL_PASSWORD"),
    [PDO::ATTR_PERSISTENT => false] // array() = [] on php 7+
);
var_dump($connection);