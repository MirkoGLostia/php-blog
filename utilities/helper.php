<?php
include 'connection.php';

class Helper
{
  public function login($new_post)
  {
    $user = $new_post->index('users', true);

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

  public function form($new_post)
  {
    if (empty($_POST['category_id'])) return header("Location: ../dashboard/form.php");

    if (isset($_POST['create'])) {
      $new_post->store($_POST['title'], $_POST['content'], $_SESSION['user_id'], $_POST['category_id'], $_FILES['image']);
    } elseif (isset($_POST['update'])) {
      $new_post->update($_POST['title'], $_POST['content'], $_POST['post_id'], $_POST['category_id'], $_FILES['image']);
    }

    header("Location: ../dashboard.php");
    exit();
  }
}

$helper = new Helper();

$new_post = new Post();
$new_post->make_connection();

$new_category = new Category();
$new_category->make_connection();

if (isset($_POST['user']) && isset($_POST['password']))
  $helper->login($new_post);
elseif (isset($_POST['logout']))
  $helper->logout();
elseif (isset($_POST['create']) || isset($_POST['update']))
  $helper->form($new_post);
elseif (isset($_POST['delete']))
  $new_post->destroy($_POST['post_id']);
elseif (isset($_POST['categories']))
  $new_category->store(trim($_POST['name']));
