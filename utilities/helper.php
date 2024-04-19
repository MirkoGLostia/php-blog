<?php
include 'connection.php';

class Helper
{
  public function login()
  {
    $connection = new Crud();
    $connection->make_connection();
    $user = $connection->index('users', true);

    $user_db = $user[0]->username;
    $password_db = $user[0]->password;
    $id_db = $user[0]->id;

    $user = $_POST['user'];
    $password = $_POST['password'];

    // Validazione
    $valid_password = password_verify($password, $password_db);
    $valid_user = false;
    if ($user_db === $user) $valid_user = true;

    if ($valid_user && $valid_password) {
      $_SESSION["verified"] = true;
      $_SESSION["user_id"] = $id_db;
      $_SESSION['username'] = $user_db;
      header("Location: ../dashboard.php");
      exit;
    } else {
      header("Location: ../login.php");
      exit;
    }
  }

  public function logout()
  {
    session_destroy();
    header("location: ../index.php");
    exit();
  }

  public function form()
  {
    $db = new Crud();
    $db->make_connection();

    if (empty($_POST['category_id'])) return header("Location: ../dashboard/form.php");

    if (isset($_POST['create'])) {
      $db->upload_file();
      $db->store($_POST['title'], $_POST['content'], $_SESSION['user_id'], $_POST['category_id']);
    } elseif (isset($_POST['update'])) {
      $db->update($_POST['title'], $_POST['content'], $_POST['post_id'], $_POST['category_id']);
    }

    header("Location: ../dashboard.php");
    exit();
  }
}

$helper = new Helper();
$db = new Crud();
$db->make_connection();

$categories = new Category();
$categories->make_connection();

if (isset($_POST['user']) && isset($_POST['password']))
  $helper->login();
elseif (isset($_POST['logout']))
  $helper->logout();
elseif (isset($_POST['create']) || isset($_POST['update']))
  $helper->form();
elseif (isset($_POST['delete']))
  $db->destroy($_POST['post_id']);
elseif (isset($_POST['categories']))
  $categories->store(trim($_POST['name']));
