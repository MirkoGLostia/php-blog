<?php

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

  public function upload_file($image, $old_image)
  {
    // Controllo l'estensione del file
    $fileExtensionsAllowed = ['jpeg', 'jpg', 'png'];

    $fileNameArr = explode('.', $image['name']);
    $fileExtension = strtolower(end($fileNameArr));

    if (!in_array($fileExtension, $fileExtensionsAllowed)) {
      header("Location: ../Admin/formPost.php");
      exit;
    }

    // Elimino la vecchia immagine salvata dello stesso post
    if ($old_image && file_exists("../storage/$old_image")) unlink("../storage/$old_image");

    // Prendo il percorso del file temporaneo e il percorso assoluto dell'immagine dentro la cartella  
    $currentDirectory = getcwd();
    $uploadDirectory = "\..\storage\\";
    $image_name = date('Ymd') . time() . $image['name'];
    $uploadPath = $currentDirectory . $uploadDirectory . basename($image_name);

    // Salvo una nuova immagine
    $fileTmpName = $image['tmp_name'];
    move_uploaded_file($fileTmpName, $uploadPath);

    return $image_name;
  }
}

$db = new Database();
$db->make_connection();
