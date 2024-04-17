<?php

class Database
{
  private $pdo;

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

  /*
    Inserisco dei dati
  */
  public function insert_data()
  {
    $sql_data = 'INSERT INTO prodotti (nome, prezzo) VALUES ("sapone liquido 100ml", 8.50)';

    $this->pdo->exec($sql_data);
  }

  public function select_data()
  {
    $sql = 'SELECT username, password FROM users';
    $sth = $this->pdo->prepare($sql);
    $result = $sth->execute();

    if (!$result) {
      die('Errore esecuzione query: ' . implode(',', $this->pdo->errorInfo()));
    }

    $products = $sth->fetchAll(PDO::FETCH_OBJ);

    return $products;
  }
}
