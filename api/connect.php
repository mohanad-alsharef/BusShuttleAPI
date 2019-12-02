<?php
require_once 'config.php';

// Connect with the database.
function connect()
{
  $connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DBNAME);

  if (mysqli_connect_errno($connect)) {
    die("Failed to connect:" . mysqli_connect_error());
  }

  mysqli_set_charset($connect, "utf8");
  return $connect;
}

$con = connect();