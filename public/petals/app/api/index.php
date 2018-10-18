<?php
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

use \Firebase\JWT\JWT;

$GLOBALS['file_path'] = dirname(dirname(dirname(__FILE__)));
//$GLOBALS['file_path'] = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";
$GLOBALS['server_url'] = "http://localhost:8080/";
$GLOBALS['server_url'] = "http://abeautifullifebykenny.com/";


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
    $app->post('/edit_gallery','editGallery');
    $app->post('/edit_gallery_folder','editGalleryFolder');
    $app->post('/edit_contributor','editContributor');
    $app->post('/get_purpose','getPurpose');
    $app->get('/get_purposes','getPurposes');
    $app->get('/get_feminique','getFeminique');
    $app->get('/get_unique','getUnique');
    $app->get('/get_gallery','getGallery');
    $app->get('/get_questions','getQuestions');
    $app->get('/get_blog','getBlog');
    $app->get('/get_events','getEvents');
    $app->get('/get_contributors','getContributors');
    $app->post('/get_single_feminique','getSingleFeminique');
    $app->post('/get_single_unique','getSingleUnique');
    $app->post('/get_single_question','getSingleQuestion');
    $app->post('/get_single_blog','getSingleBlog');
    $app->post('/get_single_event','getSingleEvent');
    $app->post('/get_single_gallery','getSingleGallery');
    $app->post('/delete_purpose','deletePurpose');
    $app->post('/delete_feminique','deleteFeminique');
    $app->post('/delete_unique','deleteUnique');
    $app->post('/delete_question','deleteQuestion');
    $app->post('/delete_blog','deleteBlog');
    $app->post('/delete_event','deleteEvent');
    $app->post('/delete_gallery','deleteGallery');
    $app->post('/delete_file','deleteFile');
    $app->get('/get_authors','getAuthorsJSON');
    $app->post('/add_feminique','addFeminique');
    $app->post('/add_unique','addUnique');
    $app->post('/add_event','addEvent');
    $app->post('/add_blog','addBlog');
    $app->post('/add_gallery_folder','addGalleryFolder');
    $app->post('/add_gallery','addGallery');
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

function getConnection()
{
    $dbhost="127.0.0.1";
    //$dbport="8889";
    $dbuser="abeautif_root";
    $dbpass="8+!38HF05ee_";
    $dbname="abeautif_main";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

/*function getConnection()
{
    $dbhost="127.0.0.1";
    //$dbport="8889";
    $dbuser="root";
    $dbpass="";
    $dbname="beautiful_life";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}*/

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

function getSingleGallery(){

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_id = $data["payload"][0]["article_id"];

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `gallery` WHERE `ID` = $article_id LIMIT 1";
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $article = $stmt->fetchAll(PDO::FETCH_OBJ);

  $dir = getDirectoryName($article_id);

  $folder_name = $dir;

  $dir = $GLOBALS['file_path'] . "/fem/gallery/" . $dir;

  $files = '<a class="add_picture" onclick="callUpload()"><i class="fa fa-2x fa-plus"></i></a>';

  foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $filename)
  {
      // filter out "." and ".."
      if ($filename->isDir()) continue;

      if($filename->getExtension() == "jpg" || $filename->getExtension() == "png" || $filename->getExtension() == "PNG" || $filename->getExtension() == "JPG" || $filename->getExtension() == "JPEG" || $filename->getExtension() == "jpeg"){
          //$filename = str_replace("../", "", $filename);
          $image_url = $filename->getFilename();
          $image_base_url = $image_url;
          $image_url = $GLOBALS['server_url'] . "fem/gallery/" . $folder_name . "/" . $image_url;
          $files = $files . "<div class='edit_picture' style='background-image:url(\"$image_url\")'><a class='deleteimagebutton' href='javascript:void(0)' data-name='$image_base_url' data-folder='$folder_name' onclick='deleteFile(this)'><i class='fas fa-times'></i></a></div>";
          //echo $filename->getExtension();
          //break;
      }
  }
  //$x_authors = getAuthors();
  //print_r($purpose);
  $resp = array('status' => "success", 'article' => $article, 'files' => $files, 'folder' => $folder_name);
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



function getGallery(){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT *, UNIX_TIMESTAMP(`created_at`) AS new_created_at FROM `gallery` ORDER BY `ID` DESC";

  //$file_path = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";
  $file_path = $GLOBALS['file_path'];

  //$file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  //print_r($sql);
  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $fashions = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_fashions= json_encode($fashions);
  $result = json_decode($json_fashions, true);
  $result_count = count($fashions);

  for ($x = 0; $x < $result_count; $x++){
    $temp_folder_name = $result[$x]["Name"];
    $temp_folder_date = $result[$x]["Event Date"];
    $folder_name = str_replace(" ", "_", strtolower($temp_folder_name)) . '_' . str_replace(" ", "_", strtolower($temp_folder_date));

    $thisdir = $file_path . "/fem/gallery/" . $folder_name;

    $front_cover = "";

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($thisdir)) as $filename)
    {
        // filter out "." and ".."
        if ($filename->isDir()) continue;

        if($filename->getExtension() == "jpg" || $filename->getExtension() == "png" || $filename->getExtension() == "PNG" || $filename->getExtension() == "JPG" || $filename->getExtension() == "JPEG" || $filename->getExtension() == "jpeg"){

          //becasue the file structure is different for the web
          $front_cover = str_replace("../", "", $filename->getFilename());
          //echo "<div class='admin_preview' style='background-image:url(\"$filename\")'></div>";
          //echo $filename->getExtension();
          break;
        }

    }

    //print_r($author_id . " - ");
    //$author_name = $author_object[0]["name"];
    //print_r($array_author_object[0]->name);
    $result[$x]["front_cover"] = $GLOBALS['server_url'] . "fem/gallery/" . $folder_name . "/" . $front_cover;
  }

  $resp = array('status' => "success", 'articles' => $result);
  echo json_encode($resp);
}


function getBaseUrl()
{
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

    // return: http://localhost/myproject/
    //return $protocol.$hostName.$pathInfo['dirname']."/";
    return $protocol.$hostName; //.$pathInfo['dirname']."/";
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

  //$file_path = dirname(dirname(dirname(dirname(__FILE__))));
  $file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

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

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}


function getDirectoryName($article_id){

  $char = "SET CHARACTER SET utf8";
  $sql = "SELECT * FROM `gallery` WHERE `ID` = $article_id";

  $db = getConnection();
  $db->query($char);
  $stmt = $db->query($sql);
  $directory = $stmt->fetchAll(PDO::FETCH_OBJ);

  $json_directory = json_encode($directory);
  $result = json_decode($json_directory, true);

  $dir = str_replace(" ", "_", $result[0]['Name']) . "_" . str_replace(" ", "_", $result[0]['Event Date']);

  $dir = strtolower($dir);

  return $dir;
}

function deleteFile(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $image_url = $data["payload"][0]["image"];
  $folder_name = $data["payload"][0]["folder"];

  unlink($GLOBALS['file_path'] . "/fem/gallery/" . $folder_name . "/" . $image_url);
}


function deleteGallery(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }



  $article_id = $data["payload"][0]["article_id"];


  $dir = getDirectoryName($article_id);

  //echo $dir;

  $dir = $GLOBALS['file_path'] . "/fem/gallery/" . $dir;

  //echo $dir;

  if(file_exists($dir)){
    deleteDirectory($dir);
  }

  //$service_id = $_POST["Service_ID"];

  $sql = "DELETE FROM `gallery` WHERE `ID`= :article_id";
  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam(":article_id", $article_id);
  $stmt->execute();

  getGallery();
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

function editGallery(){
  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  //$content = $data["payload"][0]["content"];
  //article_name: $scope.title, datetime: $scope.datetime, description: $scope.desc, folder: $scope.folder

  $views = 1;
  $name = $data["payload"][0]["article_name"];
  $date_value = $data["payload"][0]["datetime"];
  $desc = $data["payload"][0]["description"];
  $old_folder = $data["payload"][0]["folder"];
  $article_id = $data["payload"][0]["article_id"];
  //$service_id = $_POST["Service_ID"];

  $sql = "UPDATE `gallery` SET `Name`= :event_name,
  `Description`= :event_desc,`Event Date`= :event_date WHERE `id`= :article_id";

  //$sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  //VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":event_name", $name);
  $stmt->bindParam(":event_desc", $desc);
  $stmt->bindParam(":event_date", $date_value);
  $stmt->bindParam(":article_id", $article_id);
  //$stmt->bindParam(":category", $category);
  $stmt->execute();

  $dir_name = getDirectoryName($article_id);

  //rename the folder
  if ($dir_name != $old_folder){
      rename($GLOBALS['file_path'] . "/fem/gallery/" . $old_folder, $GLOBALS['file_path'] . "/fem/gallery/" . $dir_name);
      //uploadFiles($dir_name);
  }
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
    $file_path = dirname(dirname(dirname(dirname(__FILE__))));
    //$file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

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

function addGalleryFolder(){

  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $article_name = $_GET["article_name"];
  $article_date = $_GET["date_time"];

  $project_name = str_replace(" ", "_", $article_name);
  $project_date = str_replace(" ", "_", $article_date);

  $dir_name = strtolower($project_name . "_" . $project_date);

  $file_path = $GLOBALS["file_path"];
  //$file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/fem/gallery/";

  $dir = $file_path . $dir_name;

  if (!file_exists($dir) && !is_dir($dir)){
    mkdir($dir, 0777, true);
  }

  uploadFiles($dir_name);

}

function editGalleryFolder(){

  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $dir_name = $_GET["folder"];

  $file_path = $GLOBALS["file_path"];
  //$file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

  $file_path = $file_path . "/fem/gallery/";

  $dir = $file_path . $dir_name;

  if (!file_exists($dir) && !is_dir($dir)){
    mkdir($dir, 0777, true);
  }

  uploadFiles($dir_name);

}

function uploadFiles($dir_name){
    $file_path = $GLOBALS['file_path'];
    //$file_path = dirname(dirname(dirname(__FILE__))); //"../../../tenets/";

    $file_path = $file_path . "/fem/gallery/";
    // Count # of uploaded files in array
    $total = count($_FILES['file']['name']);

    // Loop through each file
    //for($i=0; $i<$total; $i++) {
    //Get the temp file path
    $tmpFilePath = $_FILES['file']['tmp_name'];

    //Make sure we have a filepath
    if ($tmpFilePath != ""){
        //Setup our new file path
        $real_name = basename($_FILES['file']['name']);

        $temp = explode(".", $_FILES["file"]["name"]);
        $newFilePath = $file_path . $dir_name . "/" . $_FILES['file']['name'];

        //Upload the file into the temp dir
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
            /*if($temp == "png" || $temp == "PNG"){
                $compressed_png_content = compress_png($newFilePath, 80);
                file_put_contents($newFilePath, $compressed_png_content);
            }*/
            //echo 'compressed';
            compressImage($newFilePath, $newFilePath, 80);
            //Handle other code here
        }

        //echo 'uploaded';
        //echo '<br/>';
        //echo $newFilePath;
        //echo '<br/>';
        //echo $tmpFilePath;
        //echo '<br/>';
        //echo $_FILES['file']['name'];
        //echo '<br/>';
        //echo $total;
    }
    //}
}

function compressImage($source_url, $destination_url, $quality) {
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
    elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
    elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

    //save file
    imagejpeg($image, $destination_url, $quality);

    //return destination file
    return $destination_url;
}

function compress_png($path_to_png_file, $max_quality = 90)
{
    if (!file_exists($path_to_png_file)) {
        throw new Exception("File does not exist: $path_to_png_file");
    }

    // guarantee that quality won't be worse than that.
    $min_quality = 60;

    // '-' makes it use stdout, required to save to $compressed_png_content variable
    // '<' makes it read from the given file path
    // escapeshellarg() makes this safe to use with any path
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg(    $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}

function addGallery(){

  $data;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $data = json_decode(file_get_contents("php://input"), true);
    //print_r($data);
  }

  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $date_time    = $data["payload"][0]["date_time"];
  $desc = $data["payload"][0]["desc"];

  $sql = "INSERT INTO `gallery`(`Name`, `Description`, `Event Date`)
  VALUES (:title,:description,:event_date)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $article_name);
  $stmt->bindParam(":description", $desc);
  $stmt->bindParam(":event_date", $date_time);
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

  $content = "";
  $views = 1;
  $article_name = $data["payload"][0]["article_name"];
  $author = $data["payload"][0]["author"];
  $category = $data["payload"][0]["category"];
  $cover = $data["payload"][0]["cover"];
  $type = $data["payload"][0]["type"];

  if(!isset($data["payload"][0]["content"])){
    $content = $data["payload"][0]["url"];
  } else {
    $content = $data["payload"][0]["content"];
    $src = $content;

    $src = str_replace("‘", "'", $src);
    $src = str_replace("’", "'", $src);
    $src = str_replace("”", '"', $src);
    $src = str_replace("“", '"', $src);
    $src = str_replace("–", "-", $src);
    $src = str_replace("…", "...", $src);
    $src = str_replace("·", "&#8226;", $src);

    $content = $src;
  }

  //$service_id = $_POST["Service_ID"];

  $sql = "INSERT INTO `mens`(`title`, `body`, `type`, `views`, `cover`, `category`, `author`)
  VALUES (:title, :content, :type, :views, :cover, :category, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
  $stmt->bindParam(":category", $category);
  $stmt->bindParam(":cover", $cover);
  $stmt->bindParam(":type", $type);
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
