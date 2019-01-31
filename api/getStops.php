<?php
/**
 * Returns a list of stops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$stops = [];

// $loop = ($_GET['loop'] !== null) ? mysqli_real_escape_string($con, $_GET['loop']) : false ;

$sql = sprintf('SELECT * FROM stops');

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
