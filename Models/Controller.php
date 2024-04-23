<?php
require_once('Auth.php');
require_once('Post.php');


/* AUTH */

if (isset($_POST['login'])) $authObj->login($_POST['username'], $_POST['password']);

elseif (isset($_POST['signup'])) $authObj->signup($_POST['username'], $_POST['password']);

elseif (isset($_POST['logout'])) $authObj->logout();


/* FORM */

if (isset($_POST['store'])) $postObj->store($_POST['title'], $_POST['content'], $_POST['category'], $_FILES['image'], $_SESSION['user_id']);

elseif (isset($_POST['update'])) $postObj->update($_POST['title'], $_POST['content'], $_POST['category'], $_FILES['image'], $_POST['update']);

elseif (isset($_POST['delete'])) $postObj->destroy($_POST['delete']);
