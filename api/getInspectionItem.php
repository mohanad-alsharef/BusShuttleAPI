<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
/**
 * Returns a list of Inspection Items for populating the list on our driver interface.
 */
require 'connect.php';

$item = [];

$sql = sprintf("SELECT * FROM inspection_items_list WHERE is_deleted='0'");

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      $item[$cr]['id'] = $row['id'];
      $item[$cr]['inspection_item_name'] = $row['inspection_item_name'];
      $item[$cr]['pre_trip_inspection'] = $row['pre_trip_inspection'];
      $item[$cr]['post_trip_inspection'] = $row['post_trip_inspection'];
    $cr++;
  }
  echo json_encode(['data'=>$item]);
}
else
{
  http_response_code(404);
}