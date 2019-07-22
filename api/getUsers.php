<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
/**
 * Returns a list of loops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$users = [];

$sql = sprintf('SELECT * FROM users WHERE is_deleted="0" ORDER BY lastname ASC');

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      $users[$cr]['id'] = $row['id'];
      $users[$cr]['firstname'] = $row['firstname'];
      $users[$cr]['lastname'] = $row['lastname'];
      
    $cr++;
  }
  echo json_encode(['data'=>$users]);
}
else
{
  http_response_code(404);
}
