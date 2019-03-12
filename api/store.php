<?php
require 'connect.php';
date_default_timezone_set('America/Indianapolis');
// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);


  // Validate.
  if(trim($request->data->boarded) === '' || trim($request->data->stop) === ''
  || trim($request->data->timestamp) === '' || trim($request->data->loop) === ''
  || trim($request->data->driver) === '' || trim($request->data->leftBehind) === ''
  || trim($request->data->busNumber) === '')
  {
    return http_response_code(400);
  }



  // Sanitize.
  $boarded = mysqli_real_escape_string($con, (int)$request->data->boarded);
  $stop = mysqli_real_escape_string($con, trim($request->data->stop));
  $timestamp = mysqli_real_escape_string($con, trim($request->data->timestamp));
  $date = date("Y/m/d");
  $loop = mysqli_real_escape_string($con, trim($request->data->loop));
  $driver = mysqli_real_escape_string($con, trim($request->data->driver));
  $leftBehind = mysqli_real_escape_string($con, trim($request->data->leftBehind));
  $busNumber = mysqli_real_escape_string($con, trim($request->data->busNumber));


  // Store.
  $sql = "INSERT INTO `Entries`(`boarded`,`stop`,`timestamp`,`date`,`loop`,`driver`, `leftBehind`, `busIdentifier`)
  VALUES ('{$boarded}','{$stop}','{$timestamp}','{$date}','{$loop}','{$driver}', '{$leftBehind}', '{$busNumber}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $log = [
      'boarded' => $boarded,
      'stop' => $stop,
      'timestamp' => $timestamp,
      'date' => $date,
      'loop' => $loop,
      'driver' => $driver,
      'leftBehind' => $leftBehind,
      'busNumber' => $busNumber
    ];
    echo json_encode(['data'=>$log]);
  }
  else
  {
    http_response_code(422);
    echo "<script>console.log( 'Could not store object in database' );</script>";
  }
}
