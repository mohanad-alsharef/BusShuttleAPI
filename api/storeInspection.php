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
  if(trim($request->data->driver) === '' || trim($request->data->loop) === ''
  || trim($request->data->busNumber) === '' || trim($request->data->timestamp) === ''
  || trim($request->data->beginningHours) === '' || trim($request->data->endingHours) === ''
  || trim($request->data->startingMileage) === '' || trim($request->data->endingMileage) === '' 
  || trim($request->data->preInspection) === '' || trim($request->data->postInspection) === '')
  {
    return http_response_code(400);
  }
  
  // Sanitize.
  $driver = mysqli_real_escape_string($con, trim($request->data->driver));
  $loop = mysqli_real_escape_string($con, trim($request->data->loop));
  $busNumber = mysqli_real_escape_string($con, trim($request->data->busNumber));
  $timestamp = mysqli_real_escape_string($con, trim($request->data->timestamp));
  $date = date("Y/m/d");
  $beginningHours = mysqli_real_escape_string($con, (int)$request->data->beginningHours);
  $endingHours = mysqli_real_escape_string($con, trim($request->data->endingHours));
  $startingMileage = mysqli_real_escape_string($con, trim($request->data->startingMileage));
  $endingMileage = mysqli_real_escape_string($con, trim($request->data->endingMileage));
  $preInspection = mysqli_real_escape_string($con, trim($request->data->preInspection));
  $postInspection = mysqli_real_escape_string($con, trim($request->data->postInspection));

  // Store.
  $sql = "INSERT INTO `inspection_report`(`driver`, `loop`, `bus_identifier`, `t_stamp`,`date_added`,`beginning_hours`,`ending_hours`, `starting_mileage`, `ending_mileage`, `pre_trip_inspection`, `post_trip_inspection` )
  VALUES ('{$driver}','{$loop}','{$busNumber}', '{$timestamp}','{$date}','{$beginningHours}','{$endingHours}', '{$startingMileage}', '{$endingMileage}', '{$preInspection}', '{$postInspection}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $log = [
      'driver' => $driver,
      'loop' => $loop,
      'bus_identifier' => $busNumber,
      't_stamp' => $timestamp,
      'date_added' => $date,
      'beginning_hours' => $beginningHours,
      'ending_hours' => $endingHours,
      'starting_mileage' => $startingMileage,
      'ending_mileage' => $endingMileage,
      'pre_trip_inspection' => $preInspection,
      'post_trip_inspection' => $postInspection
      
    ];
    echo json_encode(['data'=>$log]);
  }
  else
  {
    http_response_code(422);
    echo "<script>console.log( 'Could not store object in database' );</script>";
  }
}

