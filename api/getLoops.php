<?php
/**
 * Returns a list of loops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$loops = [];

$sql = sprintf('SELECT * FROM loops ORDER BY loops ASC');

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      $loops[$cr] = $row['loops'];
    $cr++;
  }
  echo json_encode(['data'=>$loops]);
}
else
{
  http_response_code(404);
}
