<?php
// try {
//   $pdo = new PDO("mysql:host=localhost;dbname=db_php_blog", "user", "user");
//   // Set the PDO error mode to exception
//   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//   die("ERRORE: Impossibile stabilire una connessione al database");
// }


try {
  $pdo = new PDO(
    "mysql:host=localhost;dbname=db_php_blog",
    "root",
    "root",
    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"] // La connessione utilizzerà la codifica UTF-8
  );
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  // die("Impossibile stabilire una connessione al database: " . $e.getMessage());
  die("Impossibile stabilire una connessione al database: ");
}


$sql = "CREATE TABLE `db_php_blog`.`prodotti` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(300) NOT NULL,
  `prezzo` DECIMAL(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;";

$result = $pdo->exec($sql);

if ($result) {
  echo "Tabella creata con successo";
}

$sql_data = 'INSERT INTO prodotti (nome, prezzo) VALUES ("sapone liquido 100ml", 8.50)';

$affectedRows = $pdo->exec($sql_data);

echo $affectedRows;
/*
  Stabilisco la connessione
*/

/*
  Creo una nuova tabella
*/



/*
  Inserisco dei dati
*/
