<?php
require_once 'User.php';
session_start();

class Auth extends User
{
  public function login($username, $password)
  {
    $user = $this->getUserbyName($username);
    if (!$user) {
      header("Location: ../Auth/login.php");
      exit;
    }

    $valid_password = password_verify($password, $user->password);

    if ($valid_password) {
      $_SESSION["verified"] = true;
      $_SESSION["user_id"] = $user->id;
      $_SESSION["username"] = $user->username;
      header("Location: ../Admin/index.php");
    } else {
      header("Location: ../Auth/login.php");
    }
    exit;
  }

  public function signup($username, $password)
  {
    $user = $this->getUserbyName($username);
    if ($user) {
      header("Location: ../Auth/signup.php");
      exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $statement = $this->connection->prepare("INSERT INTO `users` (`username`, `password`) VALUE (:username, :password)");

    $params = ['username' => $username, 'password' => $passwordHash];
    $execution = $statement->execute($params);

    if (!$execution) die('Errore esecuzione query');

    header("Location: ../Auth/login.php");
    exit;
  }

  public function logout()
  {
    session_destroy();
    header("location: ../index.php");
    exit();
  }
}

$authObj = new Auth();
$authObj->make_connection();
