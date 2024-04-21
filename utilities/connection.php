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

  public function upload_file($image, $old_image_name)
  {
    // Controllo l'estensione del file
    $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

    $fileNameArr = explode('.', $image['name']);
    $fileExtension = strtolower(end($fileNameArr));

    if (!in_array($fileExtension, $fileExtensionsAllowed)) return header("Location: ../dashboard/image.php");

    // Elimino la vecchia immagine salvata dello stesso post
    if (!empty($old_image_name) && file_exists("../storage/$old_image_name")) unlink("../storage/$old_image_name");

    $fileName = date('Ymd') . time() . $image['name'];

    // Prendo il percorso del file temporaneo e il percorso assoluto dell'immagine dentro la cartella  
    $fileTmpName = $image['tmp_name'];
    $currentDirectory = getcwd();
    $uploadDirectory = "\..\storage\\";
    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);

    // Salvo una nuova immagine
    move_uploaded_file($fileTmpName, $uploadPath);
  }
}

class Post extends Database
{
  /*
    Restituisce tutti i record di una tabella
  */
  public function index($user_id, $category_id)
  {
    if ($user_id == 0 && $category_id == 0) {
      $command = "SELECT * FROM `posts` ORDER BY `id` DESC";
      $params = [];
    } elseif ($user_id == 0 && $category_id != 0) {
      $command = "SELECT * FROM `posts` WHERE `category_id` = :category_id ORDER BY `id` DESC";
      $params = ['category_id' => $category_id];
    } elseif ($user_id != 0 && $category_id == 0) {
      $command = "SELECT * FROM `posts` WHERE `user_id` = :user_id ORDER BY `id` DESC";
      $params = ['user_id' => $user_id];
    } elseif ($user_id != 0 && $category_id != 0) {
      $command = "SELECT * FROM `posts` WHERE `user_id` = :user_id AND `category_id` = :category_id ORDER BY `id` DESC";
      $params = ['user_id' => $user_id, 'category_id' => $category_id];
    }

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    $posts = $statement->fetchAll(PDO::FETCH_OBJ);
    return $posts;
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
  public function store($title, $content, $user_id, $category_id, $image)
  {
    $this->upload_file($image, '');
    $image_name = date('Ymd') . time() . $image['name'];

    $command = "INSERT INTO `posts` (`title`, `content`, `user_id`, `category_id`, `image`) VALUES (:title, :content, :user_id, :category_id, :image)";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'user_id' => $user_id, 'category_id' => $category_id, 'image' => $image_name];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));
  }

  /*
    Aggiorna un record dalla tabella posts
  */
  public function update($title, $content, $post_id, $category_id, $image)
  {
    $old = $this->select($post_id);
    $this->upload_file($image, $old['image']);
    $image_name = date('Ymd') . time() . $image['name'];

    $command = "UPDATE `posts` SET `title` = :title, `content` = :content, `category_id` = :category_id, `image` = :image WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'post_id' => $post_id, 'category_id' => $category_id, 'image' => $image_name];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));
  }

  /*
    Elimina definitivamente un record dalla tabella posts
  */
  public function destroy($post_id)
  {
    $old = $this->select($post_id);
    $old_image = $old['image'];

    $command = "DELETE FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    if (file_exists("../storage/$old_image")) unlink("../storage/$old_image");

    header("Location: ../dashboard.php");
    exit();
  }

  public function postsByCategory($category_id)
  {
    $statement = $this->connection->prepare("SELECT * FROM `posts` WHERE `category_id` = :category_id");

    $params = ['category_id' => $category_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    $result = $statement->fetchAll(PDO::FETCH_OBJ);

    return $result;
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

  public function select_category($category_id)
  {
    $command = "SELECT * FROM `categories` WHERE `id` = :id";
    $params = ['id' => $category_id];

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    $category = $statement->fetch();
    return $category['name'];
  }
}

class User extends Database
{
  public function index()
  {
    $statement = $this->connection->prepare("SELECT id, username FROM `users`");
    $statement->execute();

    $users = $statement->fetchAll(PDO::FETCH_OBJ);
    return $users;
  }

  public function store($username, $password)
  {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $statement = $this->connection->prepare("INSERT INTO `users` (`username`, `password`) VALUE (:username, :password)");

    $params = ['username' => $username, 'password' => $passwordHash];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    header("Location: ../login.php");
    exit;
  }

  public function getAll($username)
  {
    $statement = $this->connection->prepare("SELECT * FROM `users` WHERE `username` = :username");

    $params = ['username' => $username];
    $statement->execute($params);

    $user = $statement->fetch(PDO::FETCH_OBJ);
    return $user;
  }

  public function getUsername($id)
  {
    $statement = $this->connection->prepare("SELECT `username` FROM `users` WHERE `id` = :id");

    $params = ['id' => $id];
    $statement->execute($params);

    $user = $statement->fetch(PDO::FETCH_OBJ);
    return $user;
  }
}
