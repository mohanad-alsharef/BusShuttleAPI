<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
/**
 * Returns a list of stops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$buses = [];

$sql = sprintf("SELECT * FROM buses WHERE is_deleted='0'");

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      $buses[$cr]['id'] = $row['id'];
      $buses[$cr]['busIdentifier'] = $row['busIdentifier'];
    $cr++;
  }
  echo json_encode(['data'=>$buses]);
}
else
{
  http_response_code(404);
}