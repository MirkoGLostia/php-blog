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
    $id_db = $user[0]->id;

    $user = $_POST['user'];
    $password = $_POST['password'];

    $valid_password = password_verify($password, $password_db);
    $valid_user = false;
    if ($user_db === $user) $valid_user = true;

    if ($valid_user && $valid_password) {
      $_SESSION["verified"] = "true";
      $_SESSION["user_id"] = $id_db;
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

  public function create_post()
  {
    $db = new Database();
    $db->make_connection();
    $db->insert_data($_POST['title'], $_POST['content'], $_SESSION['user_id']);

    header("Location: dashboard.php");
  }
}

$helper = new Helper();

if (isset($_POST['user']) && isset($_POST['password'])) {
  $helper->validation();
} elseif (isset($_POST['logout'])) {
  $helper->logout();
} elseif (isset($_POST['create'])) {
  $helper->create_post();
}
