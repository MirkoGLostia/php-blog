<?php
include 'connection.php';

class Helper
{
  public function login($new_user, $username, $password)
  {
    $user = $new_user->getAll($username);

    if (!$user) {
      header("Location: ../login.php");
      exit;
    }

    $username_db = $user->username;
    $password_db = $user->password;
    $id_db = $user->id;

    // Validazione
    $valid_password = password_verify($password, $password_db);

    if ($valid_password) {
      $_SESSION["verified"] = true;
      $_SESSION["user_id"] = $id_db;
      $_SESSION["username"] = $username_db;
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

$new_user = new User();
$new_user->make_connection();

if (isset($_POST['username']) && isset($_POST['password']))
  var_dump($helper->login($new_user, $_POST['username'], $_POST['password']));
elseif (isset($_POST['logout']))
  $helper->logout();
elseif (isset($_POST['create']) || isset($_POST['update']))
  $helper->form($new_post);
elseif (isset($_POST['delete']))
  $new_post->destroy($_POST['post_id']);
elseif (isset($_POST['categories']))
  $new_category->store(trim($_POST['name']));
elseif (isset($_POST['user_s']) && isset($_POST['password_s']))
  $new_user->store($_POST['user_s'], $_POST['password_s']);
elseif (isset($_POST['postsByCategory'])) {
  $_SESSION['category_id'] = $_POST['postsByCategory'];
  if (!$_SESSION['verified']) header("Location: ../index.php");
  else header("Location: ../dashboard.php");
}
