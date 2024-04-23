<?php
require_once 'Database.php';

class Post extends Database
{
  /*
    Restituisce tutti i record di una tabella
  */
  public function index($user_id, $category)
  {
    if ($user_id == 0 && $category == 'all') {
      $command =
        "SELECT `title`, `content`, `image`, `updated_at`, `name`, `username` FROM `posts` 
        INNER JOIN `categories` ON `categories`.`id` = `posts`.`category_id` 
        INNER JOIN `users` ON `users`.`id` = `posts`.`user_id` 
        ORDER BY `updated_at` DESC;";
      $params = [];
    } elseif ($user_id == 0 && $category != 'all') {
      $command =
        "SELECT `title`, `content`, `image`, `updated_at`, `name`, `username` FROM `posts` 
        INNER JOIN `categories` ON `categories`.`id` = `posts`.`category_id` 
        INNER JOIN `users` ON `users`.`id` = `posts`.`user_id` 
        WHERE `categories`.`name` = :category
        ORDER BY `updated_at` DESC";
      $params = ['category' => $category];
    } elseif ($user_id != 0 && $category == 'all') {
      $command =
        "SELECT `posts`.`id`, `title`, `content`, `image`, `updated_at`, `name` FROM `posts` 
        INNER JOIN `categories` ON `categories`.`id` = `posts`.`category_id` 
        WHERE `user_id` = :user_id
        ORDER BY `updated_at` DESC";
      $params = ['user_id' => $user_id];
    } elseif ($user_id != 0 && $category != 'all') {
      $command =
        "SELECT `posts`.`id`, `title`, `content`, `image`, `updated_at`, `name` FROM `posts` 
        INNER JOIN `categories` ON `categories`.`id` = `posts`.`category_id` 
        WHERE `user_id` = :user_id AND `categories`.`name` = :category
        ORDER BY `updated_at` DESC";
      $params = ['user_id' => $user_id, 'category' => $category];
    }

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    $posts = $statement->fetchAll(PDO::FETCH_OBJ);
    return $posts;
  }

  /*
    Restituisce solo un determinato record di una tabella
  */
  public function show($post_id)
  {
    $command = "SELECT * FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    $post = $statement->fetch(PDO::FETCH_OBJ);
    return $post;
  }

  /*
    Salva un nuovo record nella tabella posts
  */
  public function store($title, $content, $category_id, $image, $user_id)
  {
    $image_name = $this->upload_file($image, FALSE);

    $command = "INSERT INTO `posts` (`title`, `content`, `category_id`, `image`, `user_id`) VALUES (:title, :content, :category_id, :image, :user_id)";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'category_id' => $category_id, 'image' => $image_name, 'user_id' => $user_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    header("Location: ../Admin/index.php");
    exit;
  }

  /*
    Aggiorna un record dalla tabella posts
  */
  public function update($title, $content, $category_id, $image, $post_id)
  {
    $old_image = $this->show($post_id)->image;
    $image_name = $this->upload_file($image, $old_image);

    $command = "UPDATE `posts` SET `title` = :title, `content` = :content, `category_id` = :category_id, `image` = :image WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['title' => $title, 'content' => $content, 'category_id' => $category_id, 'image' => $image_name, 'post_id' => $post_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    header("Location: ../Admin/index.php");
    exit;
  }

  /*
    Elimina definitivamente un record dalla tabella posts
  */
  public function destroy($post_id)
  {
    $old_image = $this->show($post_id)->image;

    $command = "DELETE FROM `posts` WHERE `posts`.`id` = :post_id";
    $statement = $this->connection->prepare($command);

    $params = ['post_id' => $post_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    if (file_exists("../storage/$old_image")) unlink("../storage/$old_image");

    header("Location: ../Admin/index.php");
    exit;
  }

  public function getPostsByCategory($category_id)
  {
    $statement = $this->connection->prepare("SELECT * FROM `posts` WHERE `category_id` = :category_id");

    $params = ['category_id' => $category_id];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    $posts = $statement->fetchAll(PDO::FETCH_OBJ);
    return $posts;
  }
}

$postObj = new Post();
$postObj->make_connection();
