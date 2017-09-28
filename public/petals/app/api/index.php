<?php
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

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
    $app->post('/upload_image','uploadImage');
    $app->post('/upload_image_fem','uploadImageFem');
    $app->post('/upload_image_blog','uploadImageBlog');
    $app->post('/add_purpose','addPurpose');
    $app->get('/get_purpose','getPurpose');
    $app->post('/add_feminique','addFeminique');
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

function getPurpose(){

  $sql = "SELECT * FROM `tenets` ORDER BY `ID` DESC";
  $db = getConnection();
  $stmt = $db->query($sql);
  $purposes = $stmt->fetchAll(PDO::FETCH_OBJ);

  $resp = array('status' => "success", 'purposes' => $purposes);
  echo json_encode($resp);
}


function uploadImage(){

  $file_path = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";

  $file_path = $file_path . "/tenets" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://localhost:8080/tenets/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
    echo json_encode($resp);
  }

}

function uploadImageFem(){

  $file_path = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";

  $file_path = $file_path . "/fem" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://localhost:8080/fem/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
    echo json_encode($resp);
  }

}


function uploadImageBlog(){


  $file_path = dirname(dirname(dirname(dirname(__FILE__)))); //"../../../tenets/";

  $file_path = $file_path . "/blogs" . "/";

  $date = new DateTime();
  $timestamp = $date->getTimestamp();

  $name = $timestamp . basename( $_FILES['image']['name']);

  $file_path = $file_path . $name;

  $sent_name = "http://localhost:8080/blogs/" . $name;

  if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {

    $resp = array('status' => "success", 'link' => $sent_name);
    echo json_encode($resp);

  } else{
    $resp = array('status' => "failure", 'reason' => $_FILES['image']['error']);
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

  $sql = "INSERT INTO `tenets`(`article_name`, `views`, `content`, `author`)
  VALUES (:article_name, :views, :content, :author)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":article_name", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
  $stmt->bindParam(":author", $author);
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

  $sql = "INSERT INTO `fashions`(`title`, `body`, `views`)
  VALUES (:title, :content, :views)";

  $db = getConnection();
  $stmt = $db->prepare($sql);

  $stmt->bindParam(":title", $article_name);
  $stmt->bindParam(":views", $views);
  $stmt->bindParam(":content", $content);
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
