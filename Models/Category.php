<?php
require_once 'Database.php';

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

  public function show($name)
  {
    $command = "SELECT * FROM `categories` WHERE `name` = :name";
    $params = ['name' => $name];

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    $category = $statement->fetch(PDO::FETCH_OBJ);
    return $category;
  }

  /*
    Salva una nuova categoria
  */
  public function store($name)
  {
    if (empty($name)) {
      header("Location: ../Admin/formCategories.php");
      exit;
    }

    $command = "INSERT INTO `categories` (`name`) VALUES (:name)";
    $params = ['name' => $name];

    $statement = $this->connection->prepare($command);
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    header("Location: ../Admin/formCategories.php");
    exit;
  }
}

$categoryObj = new Category();
$categoryObj->make_connection();
