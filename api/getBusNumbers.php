<?php
/**
 * Returns a list of stops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$buses = [];

$sql = sprintf("SELECT * FROM buses");

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      // $buses[$cr]['stops'] = $row['stops'];
      $buses[$cr] = $row['busIdentifier'];
    $cr++;
  }

  echo json_encode(['data'=>$buses]);
}
else
{
  http_response_code(404);
}
