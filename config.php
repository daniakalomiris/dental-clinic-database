<?php

/**
  * configuration for database connection
  *
*/

$host       = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "db";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );