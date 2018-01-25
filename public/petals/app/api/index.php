<?php
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

use \Firebase\JWT\JWT;

try {
    // Initialize Composer autoloader
    if (!file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
        throw new \Exception('Composer dependencies not installed. Run `make install --directory app/api`');
    }
    require_once $autoload;

    // Initialize Slim Framework
    if (!class_exists('\\Slim\\Slim')) {
        throw new \Exception(
            'Missing Slim from Composer dependencies.'
            . ' Ensure slim/slim is in composer.json and run `make update --directory app/api`'
        );
    }

    // Run application
    $app = new \Api\Application();
    $app->post('/authenticate_user', 'authenticateUser');
    $app->post('/upload_image','uploadImage');
    $app->post('/edit_picture','editImage');
    $app->post('/edit_fem_picture','editFemImage');
    $app->post('/edit_unique_picture','editUniqueImage');
    $app->post('/edit_event_picture','editEventImage');
    $app->post('/edit_contributor_picture','editContributorImage');
    $app->post('/edit_first_cover','editFirstCover');
    $app->post('/edit_second_cover','editSecondCover');
    $app->post('/upload_image_fem','uploadImageFem');
    $app->post('/upload_image_unique','uploadImageUnique');
    $app->post('/upload_image_blog','uploadImageBlog');
    $app->post('/add_purpose','addPurpose');
    $app->post('/add_purpose_cover','addPurposeCover');
    $app->post('/add_fem_cover','addFemCover');
    $app->post('/add_unique_cover','addUniqueCover');
    $app->post('/add_event_cover','addEventCover');
    $app->post('/edit_purpose','editPurpose');
    $app->post('/edit_feminique','editFeminique');
    $app->post('/edit_unique','editUnique');
    $app->post('/edit_question','editQuestion');
    $app->post('/edit_blog','editBlog');
    $app->post('/edit_event','editEvent');
    $app->post('/edit_contributor','editContributor');
    $app->post('/get_purpose','getPurpose');
    $app->get('/get_purposes','getPurposes');
    $app->get('/get_feminique','getFeminique');
    $app->get('/get_unique','getUnique');
    $app->get('/get_questions','getQuestions');
    $app->get('/get_blog','getBlog');
    $app->get('/get_events','getEvents');
    $app->get('/get_contributors','getContributors');
    $app->post('/get_single_feminique','getSingleFeminique');
    $app->post('/get_single_unique','getSingleUnique');
    $app->post('/get_single_question','getSingleQuestion');
    $app->post('/get_single_blog','getSingleBlog');
    $app->post('/get_single_event','getSingleEvent');
    $app->post('/delete_purpose','deletePurpose');
    $app->post('/delete_feminique','deleteFeminique');
    $app->post('/delete_unique','deleteUnique');
    $app->post('/delete_question','deleteQuestion');
    $app->post('/delete_blog','deleteBlog');
    $app->post('/delete_event','deleteEvent');
    $app->get('/get_authors','getAuthorsJSON');
    $app->post('/add_feminique','addFeminique');
    $app->post('/add_unique','addUnique');
    $app->post('/add_event','addEvent');
    $app->post('/add_blog','addBlog');
    $app->run();

} catch (\Exception $e) {
    if (isset($app)) {
        $app->handleException($e);
    } else {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => 500,
            'statusText' => 'Internal Server Error',
            'description' => $e->getMessage(),
        ));
    }
}

function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

/*function getConnection()
{
    $dbhost="127.0.0.1";
    //$dbport="8889";
    $dbuser="abeautif_root";
    $dbpass="8+!38HF05ee_";
    $dbname="abeautif_main";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}*/

function getConnection()
{
    $dbhost="127.0.0.1";
    //$dbport="8889";
    $dbuser="root";
    $dbpass="";
    $dbname="beautiful_life";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function getAuthorById($id){

  $author_sql = "SELECT * FROM `authors` WHERE `id` = $id";
  $author_db = getConnection();
  $author_stmt = $author_db->query($author_sql);
  $author = $author_stmt->fetchAll(PDO::FETCH_OBJ);

  $json_author = json_encode($author);
  $result = json_decode($json_author, true);

  return $author;
  //$resp = array('status' => "success", 'purposes' => $purposes);
  //echo json_encode($resp);
}

function authenticateUser(){

  /*$token = array(
    "iss" => "http://example.org",
    "aud" => "http://example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000
);*/



  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }


  $username = $data["username"];
  $password = $data["password"];

  $secret_key = "45DFD3A5-890B-8C81-2B1D-7B9216505FC6";

  $sql = "SELECT * FROM `users` WHERE Email = '$username' AND Password = '$password' LIMIT 1";
  $response = array();
  try{
      $db = getConnection();
      $stmt = $db->query($sql);
      $user = $stmt->fetchAll(PDO::FETCH_OBJ);
      $db = null;
      if(sizeof($user) > 0){
        //echo json_encode($users);

        //print_r($user[0]->ID);

        $tokenId    = base64_encode(mcrypt_create_iv(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;             //Adding 10 seconds
        $expire     = $notBefore + 5.184e+6;            // Adding 60 seconds
        $serverName = "PETALS";

        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss'  => $serverName,       // Issuer
            'nbf'  => $notBefore,        // Not before
            'exp'  => $expire,           // Expire
            'data' => [                  // Data related to the signer user
                'userId'   => $user[0]->ID, // userid from the users table
                'email' => $username, // User name
            ]
        ];

        $jwt = JWT::encode($data, $secret_key);
        $response["status"] = "success";
        $response["token"] = $jwt;

        echoResponse(200, $response);
      } else {
        $response["status"] = "error";
        $response["message"] = "Wrong login details";

        echoResponse(200, $response);
      }
  }catch(PDOException $e){
      echo '{"error":{"text":'. $e->getMessage() .'}}';
  }



/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */


}

function getAuthors(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `authors`";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $authors = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_author = json_encode($authors);
  $result = json_decode($json_author, true);
  //print_r("balls");

  return $authors;
  //$resp = array('status' => "success", 'purposes' => $purposes);
  //echo json_encode($resp);
}

function getAuthorsJSON(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `authors`";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $authors = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_author = json_encode($authors);
  $result = json_decode($json_author, true);
  //print_r("balls");

  //return $authors;
  $resp = array('status' => "success", 'authors' => $authors);
  echo json_encode($resp);
}

function embrace(){
  $embrace = getAuthors();
  print_r($embrace);
}

function getSingleFeminique(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `fashions` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $article = $stmt->fetchAll(PDO::FETCH_OBJ);

  $x_authors = getAuthors();

  //print_r($purpose);

  $resp = array('status' => "success", 'article' => $article, 'authors' => $x_authors);
  //print_r($resp);
  echo json_encode($resp);
}

function getSingleUnique(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `mens` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $article = $stmt->fetchAll(PDO::FETCH_OBJ);

  $x_authors = getAuthors();

  //print_r($purpose);

  $resp = array('status' => "success", 'article' => $article, 'authors' => $x_authors);
  //print_r($resp);
  echo json_encode($resp);
}

function getSingleBlog(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `blogs` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $article = $stmt->fetchAll(PDO::FETCH_OBJ);

  //$x_authors = getAuthors();

  //print_r($purpose);

  $resp = array('status' => "success", 'article' => $article);
  //print_r($resp);
  echo json_encode($resp);
}

function getSingleQuestion(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `questions` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $article = $stmt->fetchAll(PDO::FETCH_OBJ);

  //$x_authors = getAuthors();

  //print_r($purpose);

  $resp = array('status' => "success", 'article' => $article);
  //print_r($resp);
  echo json_encode($resp);
}

function getSingleEvent(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`event_date`) AS new_created_at FROM `events` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $article = $stmt->fetchAll(PDO::FETCH_OBJ);

  //$x_authors = getAuthors();

  //print_r($purpose);

  $resp = array('status' => "success", 'article' => $article);
  //print_r($resp);
  echo json_encode($resp);
}

function getPurpose(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `tenets` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $purpose = $stmt->fetchAll(PDO::FETCH_OBJ);

  $x_authors = getAuthors();

  //print_r($purpose);

  $resp = array('status' => "success", 'purpose' => $purpose, 'authors' => $x_authors);
  //print_r($resp);
  echo json_encode($resp);
}

function getPurposes(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `tenets` ORDER BY `ID` DESC";
  $db = getConnection();

  $db->query($char);
  $stmt = $db->query($sql);
  $purposes = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_purposes = json_encode($purposes);
  $result = json_decode($json_purposes, true);
  $result_count = count($purposes);

  for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }

  $resp = array('status' => "success", 'purposes' => $result);
  echo json_encode($resp);
}


function getFeminique(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `fashions` ORDER BY `ID` DESC";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }

  $resp = array('status' => "success", 'fashions' => $result);
  echo json_encode($resp);
}


function getContributors(){
  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `authors` ORDER BY `ID` DESC";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  /*for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }*/

  $resp = array('status' => "success", 'authors' => $result);
  echo json_encode($resp);
}

function getEvents(){
  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`event_date`) AS new_created_at FROM `events` ORDER BY `ID` DESC";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  /*for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }*/

  $resp = array('status' => "success", 'questions' => $result);
  echo json_encode($resp);
}


function getBlog(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `blogs` ORDER BY `ID` DESC";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  /*for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }*/

  $resp = array('status' => "success", 'blogs' => $result);
  echo json_encode($resp);
}

function getQuestions(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `questions` ORDER BY `ID` DESC";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  /*for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }*/

  $resp = array('status' => "success", 'questions' => $result);
  echo json_encode($resp);
}

function getUnique(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `mens` ORDER BY `ID` DESC";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  for ($x = 0; $x < $result_count; $x++){
    $author_id = $result[$x]["author"];

    //print_r($author_id . " - ");
    $author_object = getAuthorById($author_id);

    $array_author_object = (array) $author_object;

    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["author_name"] = $array_author_object[0]->name;
  }

  $resp = array('status' => "success", 'articles' => $result);
  echo json_encode($resp);
}




function editImage(){

  $tenet_id = $_GET["id"];

  //$file_path = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";
  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/tenets" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/tenets/" . $name;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

  $sql = "UPDATE `tenets` SET `cover`= '$name' WHERE `id`= $tenet_id";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $db = null;

}

function editFemImage(){

  $tenet_id = $_GET["id"];

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/fem" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/fem/" . $name;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

  $sql = "UPDATE `fashions` SET `cover`= '$name' WHERE `id`= $tenet_id";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $db = null;
}


function editContributorImage(){

  $tenet_id = $_GET["id"];

  $file_path = dirname(dirname(dirname(dirname(__FILE__))));
  //$file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/authors" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename($_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/authors/" . $name;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $sql = "UPDATE `authors` SET `avatar`= '$name' WHERE `id`= $tenet_id";

    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $db = null;

    getContributors();
    //$resp = array('status' => "success", 'link' => $sent_name);
    //echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

}


function editEventImage(){

  $tenet_id = $_GET["id"];

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/events" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/events/" . $name;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

  $sql = "UPDATE `events` SET `header`= '$name' WHERE `id`= $tenet_id";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $db = null;

}


function editFirstCover(){

  //$tenet_id = $_GET["id"];

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/images" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = "beautiful_bg.png"; //$timestamp . basename( $_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/images/" . $name  . "?" . $timestamp;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

}

function editSecondCover(){

  //$tenet_id = $_GET["id"];

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/images" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = "second_beautiful_bg.png"; //$timestamp . basename( $_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/images/" . $name . "?" . $timestamp;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

}


function editUniqueImage(){

  $tenet_id = $_GET["id"];

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/unique" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['file']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/unique/" . $name;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
    echo json_encode($resp);
  }

  $sql = "UPDATE `mens` SET `cover`= '$name' WHERE `id`= $tenet_id";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $db = null;

}

function uploadImage(){

  //$file_path = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";
  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/tenets" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  //$sent_name = "http://localhost:8080/tenets/" . $name;

  $sent_name = "http://abeautifullifebykenny.com/tenets/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
    echo json_encode($resp);
  }

}

function uploadImageUnique(){

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/unique" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/unique/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
    echo json_encode($resp);
  }

}

function uploadImageFem(){

  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/fem" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/fem/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
    echo json_encode($resp);
  }

}


function uploadImageBlog(){


  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/blogs" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://abeautifullifebykenny.com/blogs/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
    echo json_encode($resp);
  }

}

function deletePurpose(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $tenet_id = $data["payload"][0]["tenet_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `tenets` WHERE `id`= :tenet_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":tenet_id", $tenet_id);
  $stmt->execute();

  getPurposes();
}

function deleteFeminique(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `fashions` WHERE `ID`= :article_id";
  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->execute();

  getFeminique();
}

function deleteUnique(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `mens` WHERE `ID`= :article_id";
  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->execute();

  getUnique();
}

function deleteEvent(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `events` WHERE `ID`= :article_id";
  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->execute();

  getEvents();
}

function deleteBlog(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `blogs` WHERE `ID`= :article_id";
  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->execute();

  getBlog();
}

function deleteQuestion(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `questions` WHERE `ID`= :article_id";
  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->execute();

  getQuestions();
}

function editPurpose(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $tenet_id = $data["payload"][0]["tenet_id"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `tenets` SET `article_name`=:article_name,
  `category`=:category,
  `content`=:content,`author`=:author WHERE `id`= :tenet_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":article_name", $article_name);
  $stmt->bindParam(":tenet_id", $tenet_id);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->execute();
}


function editUnique(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $article_id = $data["payload"][0]["article_id"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `mens` SET `title`=:article_name,
  `category`=:category,
  `body`=:content,`author`=:author WHERE `id`= :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":article_name", $article_name);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->execute();
}

function editQuestion(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  //$content = $data["payload"][0]["content"];
  $views = 1;
  $answer = $data["payload"][0]["kenny"];
  $ade = $data["payload"][0]["ade"];
  $sade = $data["payload"][0]["sade"];
  $article_id = $data["payload"][0]["article_id"];

  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `questions` SET `Answer`=:answer,
  `ade`= :ade,
  `sade`=:sade WHERE `id`= :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":answer", $answer);
  $stmt->bindParam(":ade", $ade);
  $stmt->bindParam(":sade", $sade);
  $stmt->bindParam(":article_id", $article_id);
  //$stmt->bindParam(":category", $category);
  $stmt->execute();
}

function editBlog(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  //$content = $data["payload"][0]["content"];
  $views = 1;
  $title = $data["payload"][0]["title"];
  $body = $data["payload"][0]["body"];
  $article_id = $data["payload"][0]["article_id"];

  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `blogs` SET `title`=:title,
  `body`= :body WHERE `id`= :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":body", $body);
  $stmt->bindParam(":article_id", $article_id);
  //$stmt->bindParam(":category", $category);
  $stmt->execute();
}

function editEvent(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  //$content = $data["payload"][0]["content"];
  $views = 1;
  $name = $data["payload"][0]["name"];
  $org = $data["payload"][0]["org"];
  $desc = $data["payload"][0]["desc"];
  $date_value = $data["payload"][0]["date_value"];
  $article_id = $data["payload"][0]["article_id"];

  if (strlen($desc > 140)){
    $brief = substr($desc, 0, 140) . "...";
  } else {
    $brief = $desc;
  }

  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `events` SET `event_name`= :event_name,`organizer`=:event_org,
  `description`=:event_brief_desc,`full_description`= :event_desc,
  `event_date`=:event_date WHERE `id`= :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":event_name", $name);
  $stmt->bindParam(":event_org", $org);
  $stmt->bindParam(":event_brief_desc", $brief);
  $stmt->bindParam(":event_desc", $desc);
  $stmt->bindParam(":event_date", $date_value);
  $stmt->bindParam(":article_id", $article_id);
  //$stmt->bindParam(":category", $category);
  $stmt->execute();
}

function editContributor(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  //$content = $data["payload"][0]["content"];
  $views = 1;
  $name = $data["payload"][0]["name_value"];
  $desc = $data["payload"][0]["desc_value"];
  $article_id = $data["payload"][0]["article_id"];

  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `authors` SET `name`=:name,`description`= :desc_value WHERE `id` = :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":desc_value", $desc);
  $stmt->bindParam(":article_id", $article_id);
  //$stmt->bindParam(":category", $category);
  $stmt->execute();
}

function editFeminique(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $article_id = $data["payload"][0]["article_id"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `fashions` SET `title`=:article_name,
  `category`=:category,
  `body`=:content,`author`=:author WHERE `id`= :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":article_name", $article_name);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->execute();
}

function addPurposeCover(){
    //$tenet_id = $_GET["id"];
    $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

    $file_path = $file_path . "/tenets" . "/";

    $date = new DateTime();
    $timestamp = $date->getTimestamp();

    $name = $timestamp . basename( $_FILES['file']['name']);

    $file_path = $file_path . $name;

    //$sent_name = "http://abeautifullifebykenny.com/tenets/" . $name;

    if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

      $resp = array('status' => "success", 'name' => $name);
      echo json_encode($resp);

    } else{
      $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
      echo json_encode($resp);
    }
}

function addFemCover(){
    //$tenet_id = $_GET["id"];
    $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

    $file_path = $file_path . "/fem" . "/";

    $date = new DateTime();
    $timestamp = $date->getTimestamp();

    $name = $timestamp . basename( $_FILES['file']['name']);

    $file_path = $file_path . $name;

    //$sent_name = "http://abeautifullifebykenny.com/tenets/" . $name;

    if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

      $resp = array('status' => "success", 'name' => $name);
      echo json_encode($resp);

    } else{
      $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
      echo json_encode($resp);
    }
}

function addEventCover(){
    //$tenet_id = $_GET["id"];
    $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

    $file_path = $file_path . "/events" . "/";

    $date = new DateTime();
    $timestamp = $date->getTimestamp();

    $name = $timestamp . basename( $_FILES['file']['name']);

    $file_path = $file_path . $name;

    //$sent_name = "http://abeautifullifebykenny.com/tenets/" . $name;

    if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

      $resp = array('status' => "success", 'name' => $name);
      echo json_encode($resp);

    } else{
      $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
      echo json_encode($resp);
    }
}

function addUniqueCover(){
    //$tenet_id = $_GET["id"];
    $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

    $file_path = $file_path . "/unique" . "/";

    $date = new DateTime();
    $timestamp = $date->getTimestamp();

    $name = $timestamp . basename( $_FILES['file']['name']);

    $file_path = $file_path . $name;

    //$sent_name = "http://abeautifullifebykenny.com/tenets/" . $name;

    if(move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {

      $resp = array('status' => "success", 'name' => $name);
      echo json_encode($resp);

    } else{
      $resp = array('status' => "failure", 'reason' => $_FILES['file']['error']);
      echo json_encode($resp);
    }
}

function addPurpose(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $cover = $data["payload"][0]["cover"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`, `cover`, `category`)
  VALUES (:article_name, :views, :content, :author, :cover, :category)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":article_name", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->bindParam(":cover", $cover);
  $stmt->execute();
}

function addEvent(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $name = $data["payload"][0]["name"];
  $org = $data["payload"][0]["org"];
  $desc = $data["payload"][0]["desc"];
  $date_value = $data["payload"][0]["date_value"];
  $cover = $data["payload"][0]["cover"];

  //$service_id = $_POST["Service_ID"];
  if (strlen($desc > 140)){
    $brief = substr($desc, 0, 140) . "...";
  } else {
    $brief = $desc;
  }

  $sql = "INSERT INTO `events` (`event_name`, `organizer`, `description`,
  `full_description`, `header`, `event_date`) VALUES
  (:event_name,:event_org, :short_desc, :full_desc,:header,:event_date)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":event_name", $name);
  $stmt->bindParam(":event_org", $org);
  $stmt->bindParam(":short_desc", $brief);
  $stmt->bindParam(":full_desc", $desc);
  $stmt->bindParam(":header", $cover);
  $stmt->bindParam(":event_date", $date_value);
  //$stmt->bindParam(":author", $author);
  $stmt->execute();
}


function addUnique(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $cover = $data["payload"][0]["cover"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "INSERT INTO `mens`(`title`, `body`, `views`, `cover`, `category`, `author`)
  VALUES (:title, :content, :views, :cover, :category, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->bindParam(":cover", $cover);
  //$stmt->bindParam(":author", $author);
  $stmt->execute();
}

function addFeminique(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $cover = $data["payload"][0]["cover"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "INSERT INTO `fashions`(`title`, `body`, `views`, `cover`, `category`, `author`)
  VALUES (:title, :content, :views, :cover, :category, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->bindParam(":cover", $cover);
  //$stmt->bindParam(":author", $author);
  $stmt->execute();
}

function addBlog(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $content = $data["payload"][0]["content"];
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];

  $src = $content;

  $src = str_replace("‘", "'", $src);
  $src = str_replace("’", "'", $src);
  $src = str_replace("”", '"', $src);
  $src = str_replace("“", '"', $src);
  $src = str_replace("–", "-", $src);
  $src = str_replace("…", "...", $src);
  $src = str_replace("·", "&#8226;", $src);

  $content = $src;
  //$service_id = $_POST["Service_ID"];

  $sql = "INSERT INTO `blogs`(`title`, `body`, `views`)
  VALUES (:title, :content, :views)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
  //$stmt->bindParam(":author", $author);
  $stmt->execute();
}
