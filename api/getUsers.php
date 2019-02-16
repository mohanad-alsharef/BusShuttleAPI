<?php
/**
 * Returns a list of loops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$users = [];

// $loop = ($_GET['loop'] !== null) ? mysqli_real_escape_string($con, $_GET['loop']) : false ;

$sql = sprintf('SELECT * FROM users');

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      // $loops[$cr]['loops'] = $row['loops'];
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
