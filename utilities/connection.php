<?php
session_start();

class Database
{
  protected $connection;

  /*
    Stabilisce la connessione con il database
  */
  public function make_connection()
  {
    try {
      $this->connection = new PDO(
        "mysql:host=localhost;dbname=db_php_blog", // linguaggio database - url di riferimento - nome del database
        "root", // username
        "root", // password
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"] // facoltativo, sono opzioni 
      );
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Impossibile stabilire una connessione al database: " . $e->getMessage());
    }
  }

  public function upload_file()
  {
    $currentDirectory = getcwd();
    $uploadDirectory = "/../storage/";

    $errors = [];

    $fileExtensionsAllowed = ['jpeg','jpg','png'];

    $fileName = $_FILES['image']['name'];
    $fileTmpName  = $_FILES['image']['tmp_name'];
    $fileType = $_FILES['image']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 

    if (! in_array($fileExtension,$fileExtensionsAllowed)) {
      $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
    }

    if (empty($errors)) {
      $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

      if ($didUpload) {
        echo "The file " . basename($fileName) . " has been uploaded";
      } else {
        echo "An error occurred. Please contact the administrator.";
      }
    } else {
      foreach ($errors as $error) {
        echo $error . "These are the errors" . "\n";
      }
    }
  }
}

class Crud extends Database
{
  /*
    Restituisce tutti i record di una tabella
  */
  public function index($query, $public)
  {
    $condiction = isset($_SESSION['verified']) && !$public;

    if ($condiction) {
      $user_id = $_SESSION['user_id'];
      $command = "SELECT * FROM " . $query . " WHERE `posts`.`user_id` = " . $user_id;
    } else {
      $command = "SELECT * FROM " . $query;
    }

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute();

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    return $result;
  }

  /*
    Restituisce solo un determinato record di una tabella
  */
  public function select($post_id)
  {
    $command = "SELECT * FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    $post = $statement->fetch();
    return $post;
  }

  /*
    Salva un nuovo record nella tabella posts
  */
  public function store($title, $content, $user_id, $category_id)
  {
    $command = "INSERT INTO `posts` (`title`, `content`, `user_id`, `category_id`) VALUES (:title, :content, :user_id, :category_id)";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'user_id' => $user_id, 'category_id' => $category_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));
  }

  /*
    Aggiorna un record dalla tabella posts
  */
  public function update($title, $content, $post_id, $category_id)
  {
    $command = "UPDATE `posts` SET `title` = :title, `content` = :content, `category_id` = :category_id WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'post_id' => $post_id, 'category_id' => $category_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));
  }

  /*
    Elimina definitivamente un record dalla tabella posts
  */
  public function destroy($post_id)
  {
    $command = "DELETE FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    header("Location: ../dashboard.php");
    exit();
  }
}

class Category extends Database
{
  /*
    Restituisce un oggetto con il name di tutte le categorie
  */
  public function index()
  {
    $command = "SELECT * FROM `categories`";

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute();

    if (!$execution) die('Errore esecuzione query');

    $categories = $statement->fetchAll(PDO::FETCH_OBJ);
    return $categories;
  }

  /*
    Salva una nuova categoria
  */
  public function store($name)
  {
    if (empty($name)) return header("Location: ../dashboard/form_categories.php");
    $command = "INSERT INTO `categories` (`name`) VALUES (:name)";
    $params = ['name' => $name];

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    header("Location: ../dashboard/form_categories.php");
    exit();
  }
}
