<?php
// header('Access-Control-Allow_Origin: *');
// header('Content-type: application/json');
// header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');

// header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
// // // Makes IE to support cookies
// header("Content-Type: application/json; charset=utf-8");

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

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();
$db = $database->connect();

$post = new Post($db);

$result = $post->read();
$num=$result->rowCount();

if($num>0){
$posts_arr = array();
$posts_arr['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)){
extract($row);

$post_item = array(
'id'=>$id,
'uname' => $uname,
'email' => $email,
'phone'=> $phone,
'date_query'=>$date_query,
'comments' => $comments
);

array_push($posts_arr['data'],$post_item);
}
echo json_encode($posts_arr);
}else{
echo json_encode(
array('message' => 'No post found') 
);

}