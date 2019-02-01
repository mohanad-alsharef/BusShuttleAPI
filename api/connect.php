<?php
require_once 'config.php';

// Connect with the database.
function connect()
{
  $connect = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME);

  if (mysqli_connect_errno($connect)) {
    die("Failed to connect:" . mysqli_connect_error());
  }

  mysqli_set_charset($connect, "utf8");
  return $connect;
}

$con = connect();
