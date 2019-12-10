<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'Database.php';
include_once 'objects/user.php';

require_once('ulogin/config/all.inc.php');
require_once('ulogin/main.inc.php');

function appLogin($uid, $username, $ulogin){
	$_SESSION['uid'] = $uid;
	$_SESSION['username'] = $username;
	$_SESSION['loggedIn'] = true;

	if (isset($_SESSION['appRememberMeRequested']) && ($_SESSION['appRememberMeRequested'] === true))
	{
		// Enable remember-me
		if ( !$ulogin->SetAutologin($username, true))
			echo "cannot enable autologin<br>";

		unset($_SESSION['appRememberMeRequested']);
	}
	else
	{
		// Disable remember-me
		if ( !$ulogin->SetAutologin($username, false))
			echo 'cannot disable autologin<br>';
	}
}

function appLoginFail($uid, $username, $ulogin){
	// Note, in case of a failed login, $uid, $username or both
	// might not be set (might be NULL).
	$loginFailed = "Login failed, please try again.";
	//echo "<div align='center' class='alert-danger'>Login failed, please try again.</div>";
}

$ulogin = new uLogin('appLogin', 'appLoginFail');

$database = new Database();
$db = $database->getConnection();

$user = new UserObject($db);
 
$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;
$email_exists = $user->emailExists();

//include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$ulogin->Authenticate($user->email,  $data->password);

if($ulogin->IsAuthSuccess()) {

    $token = ulNonce::Create('login');
 
    http_response_code(200);
 
    echo json_encode(
            array(
                "email" => $user->email,
                "token" => $token
            )
        );
}
else{

    http_response_code(403);
    echo json_encode(array("message" => "Username or Password was Incorrect."));
}
?>