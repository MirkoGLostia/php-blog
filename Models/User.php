<?php
require_once 'Database.php';

class User extends Database
{
  public function index()
  {
    $statement = $this->connection->prepare("SELECT id, username FROM `users`");
    $statement->execute();

    $users = $statement->fetchAll(PDO::FETCH_OBJ);
    return $users;
  }

  public function getUserbyName($username)
  {
    $statement = $this->connection->prepare("SELECT * FROM `users` WHERE `username` = :username");

    $params = ['username' => $username];
    $statement->execute($params);

    $user = $statement->fetch(PDO::FETCH_OBJ);
    return $user;
  }

  public function getUserbyId($id)
  {
    $statement = $this->connection->prepare("SELECT `username` FROM `users` WHERE `id` = :id");

    $params = ['id' => $id];
    $statement->execute($params);

    $user = $statement->fetch(PDO::FETCH_OBJ);
    return $user;
  }
}

$userObj = new User();
$userObj->make_connection();
