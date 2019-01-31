<?php
/**
 * Returns the list of cars.
 */
require 'connect.php';

$loops = [];

// $loop = ($_GET['loop'] !== null) ? mysqli_real_escape_string($con, $_GET['loop']) : false ;

// $sql = "SELECT * FROM Entries WHERE loop = `Green Loop`";
$sql = sprintf('SELECT * FROM loops');

// $sql = "SELECT * FROM `Entries` WHERE `Entries`.`loop`='Green Loop'";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      // $loops[$cr]['loops'] = $row['loops'];
      $loops[$cr] = $row['loops'];
    $cr++;
  }

  echo json_encode(['data'=>$loops]);
}
else
{
  http_response_code(404);
}
