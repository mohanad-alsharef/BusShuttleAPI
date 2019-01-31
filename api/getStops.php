<?php
/**
 * Returns the list of cars.
 */
require 'connect.php';

$stops = [];

// $loop = ($_GET['loop'] !== null) ? mysqli_real_escape_string($con, $_GET['loop']) : false ;

// $sql = "SELECT * FROM Entries WHERE loop = `Green Loop`";
$sql = sprintf('SELECT * FROM stops');

// $sql = "SELECT * FROM `Entries` WHERE `Entries`.`loop`='Green Loop'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      // $stops[$cr]['stops'] = $row['stops'];
      $stops[$cr] = $row['stops'];
    $cr++;
  }

  echo json_encode(['data'=>$stops]);
}
else
{
  http_response_code(404);
}
