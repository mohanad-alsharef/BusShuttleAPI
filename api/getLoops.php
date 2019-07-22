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

$loops = [];

$sql = sprintf('SELECT * FROM loops WHERE is_deleted="0" ORDER BY loops ASC');

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      $loops[$cr]['id'] = $row['id'];
      $loops[$cr]['loopName'] = $row['loops'];
    $cr++;
  }
  echo json_encode(['data'=>$loops]);
}
else
{
  http_response_code(404);
}
