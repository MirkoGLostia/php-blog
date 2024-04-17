<?php
session_start();
include 'connection.php';

class Helper
{

  public function validation()
  {

    $connection = new Database();
    $connection->make_connection();
    $user = $connection->select_data();

    $user_db = $user[0]->username;
    $password_db = $user[0]->password;

    $user = $_POST['user'];
    $password = $_POST['password'];

    $valid_password = password_verify($password, $password_db);
    $valid_user = false;
    if ($user_db === $user) $valid_user = true;

    if ($valid_user && $valid_password) {
      $_SESSION["verified"] = "true";
      header("Location:dashboard.php");
      exit;
    } else {
      header("Location: login.php");
    }
  }

  public function logout()
  {
    session_destroy();
    header("location:index.php");
    exit();
  }
}

$helper = new Helper();

if (isset($_POST['user']) && isset($_POST['password'])) {
  $helper->validation();
} elseif (isset($_POST['logout'])) {
  $helper->logout();
}
