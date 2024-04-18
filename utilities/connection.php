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
    $result = $statement->execute();

    if (!$result) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    $products = $statement->fetchAll(PDO::FETCH_OBJ);
    return $products;
  }

  /*
    Restituisce solo un determinato record di una tabella
  */
  public function select($post_id)
  {
    $command = "SELECT * FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $result = $statement->execute($params);

    if (!$result) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    $post = $statement->fetch();
    return $post;
  }

  /*
    Salva un nuovo record nella tabella posts
  */
  public function store($title, $content, $user_id)
  {
    $command = "INSERT INTO `posts` (`title`, `content`, `user_id`) VALUES (:title, :content, :user_id)";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'user_id' => $user_id];
    $result = $statement->execute($params);

    if (!$result) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));
  }

  /*
    Aggiorna un record dalla tabella posts
  */
  public function update($title, $content, $post_id)
  {
    $command = "UPDATE `posts` SET `title` = :title, `content` = :content WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'post_id' => $post_id];
    $result = $statement->execute($params);

    if (!$result) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));
  }

  /*
    Elimina definitivamente un record dalla tabella posts
  */
  public function destroy($post_id)
  {
    $command = "DELETE FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $result = $statement->execute($params);

    if (!$result) die('Errore esecuzione query: ' . implode(',', $this->connection->errorInfo()));

    header("Location: ../dashboard.php");
    exit();
  }
}
