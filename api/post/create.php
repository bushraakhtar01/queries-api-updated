<?php
// header('Access-Control-Allow_Origin: *');
// header('Content-type: application/json');
// header('Access-Control-Allow-Methods: POST');
// header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
//  Access-Control-Allow-Methods, Authorization, X-Requested-With, Origin, Accept');
// header('Access-Control-Request-Headers:content-type');
// header('Access-Control-Request-Method:POST');
// header('Access-Control-Allow-Credentials:true');

if (isset($_SERVER["HTTP_ORIGIN"]) === true) {
	$origin = $_SERVER["HTTP_ORIGIN"];
	$allowed_origins = array(
    
        "http://localhost:3000",
        "http://localhost:3001",
        "http://192.168.2.106:3000"
	);
	if (in_array($origin, $allowed_origins, true) === true) {
		header('Access-Control-Allow-Origin: ' . $origin);
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type');
	}
	if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
		exit; // OPTIONS request wants only the policy, we can stop here
	}
}
// // Makes IE to support cookies

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();
$post = new Post($db);
$data=json_decode(file_get_contents("php://input"));


$post->uname =$_POST["uname"];
$post->email =$_POST["email"];
$post->phone =$_POST["phone"];
$post->date_query=$_POST["date_query"];
$post->comments = $_POST["comments"];

if($post->create()) {
    echo json_encode(
     array('message'=> 'Post Created')
	);
	
} else {
    echo json_encode(
        array('message'=> 'Post Not Created')
    );
}

