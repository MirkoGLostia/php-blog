<?php

class Database
{
  protected $pdo;

  /*
    Stabilisco la connessione
  */
  public function make_connection()
  {
    try {
      $this->pdo = new PDO(
        "mysql:host=localhost;dbname=db_php_blog",
        "root",
        "root",
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
      );
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      // die("Impossibile stabilire una connessione al database: " . $e.getMessage());
      die("Impossibile stabilire una connessione al database: ");
    }
  }

  /*
    Creo una nuova tabella
  */
  public function create_table()
  {
    $sql = "CREATE TABLE `db_php_blog`.`prodotti` (
      `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `nome` VARCHAR(300) NOT NULL,
      `prezzo` DECIMAL(6,2) NOT NULL,
      PRIMARY KEY (`id`) ) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;";

    $this->pdo->exec($sql);
  }
}

class Crud extends Database
{
  /*
    Create: Aggiugno nuovi dati
  */
  public function create($title, $content, $user_id)
  {
    $sql = "INSERT INTO posts (title, content, user_id) 
      VALUES (:title, :content, :user_id)";

    $params = ['title' => $title, 'content' => $content, 'user_id' => $user_id,];

    $sth = parent::$pdo->prepare($sql);

    $result = $sth->execute($params);

    if (!$result) {
      die('Errore esecuzione query: ' . implode(',', parent::$pdo->errorInfo()));
    }
  }

  /*
    Read: Seleziono dei dati da leggere
  */
  public function index()
  {
    $sql = 'SELECT * FROM users';
    $sth = parent::$pdo->prepare($sql);
    $result = $sth->execute();

    if (!$result) {
      die('Errore esecuzione query: ' . implode(',', parent::$pdo->errorInfo()));
    }

    $products = $sth->fetchAll(PDO::FETCH_OBJ);

    return $products;
  }


  /*
    Update: Aggiorno dati esistenti
  */
  public function update()
  {
  }


  /*
    Update: Aggiorno dati esistenti
  */
  public function delete()
  {
  }
}
