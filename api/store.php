<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
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


  // Check for dublicate
  $check = mysqli_query($con,"SELECT * FROM `entries` WHERE `boarded`=$boarded AND `stop`=$stop AND `loop`=$loop AND `driver`=$driver AND `left_behind`=$leftBehind AND `bus_identifier`=$busNumber AND `t_stamp`LIKE '$timestamp'");
  $checkrows=mysqli_num_rows($check);

  // Store.
  if($checkrows > 0) {
    http_response_code(201);
    $log = [
      'boarded' => $boarded,
      'stop' => $stop,
      't_stamp' => $timestamp,
      'date' => $date,
      'loop' => $loop,
      'driver' => $driver,
      'left_behind' => $leftBehind,
      'bus_identifier' => $busNumber
    ];
    echo json_encode(['data'=>$log]);
  } else {
    $sql = "INSERT INTO `entries`(`boarded`,`stop`,`t_stamp`,`date_added`,`loop`,`driver`, `left_behind`, `bus_identifier`)
  VALUES ('{$boarded}','{$stop}','{$timestamp}','{$date}','{$loop}','{$driver}', '{$leftBehind}', '{$busNumber}')";
  if(mysqli_query($con,$sql))
  {
    // uncomment sleep to test the duplication porblem
    //sleep(60);
    http_response_code(201);
    $log = [
      'boarded' => $boarded,
      'stop' => $stop,
      't_stamp' => $timestamp,
      'date' => $date,
      'loop' => $loop,
      'driver' => $driver,
      'left_behind' => $leftBehind,
      'bus_identifier' => $busNumber
    ];
    echo json_encode(['data'=>$log]);
  }
  else
  {
    http_response_code(422);
    echo "<script>console.log( 'Could not store object in database' );</script>";
  }
  }
  

  
}
