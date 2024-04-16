<?php

include 'connection.php';

function validation()
{

  $connection = new Database();
  $connection->make_connection();
  $user = $connection->select_product();

  $user_db = $user[0]->username;
  $password_db = $user[0]->password;

  $user = $_POST['user'];
  $password = $_POST['password'];

  $valid_password = password_verify($password, $password_db);
  $valid_user = false;
  if ($user_db === $user) $valid_user = true;

  if ($valid_user && $valid_password) {
    header("Location:dashboard.php");
    exit;
  } else {
    header("Location: login.php");
  }
}

validation();
