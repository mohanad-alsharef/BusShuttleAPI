<?php
/**
 * Returns a list of loops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$users = [];

$sql = sprintf('SELECT * FROM users');

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
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
