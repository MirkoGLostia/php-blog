<?php
session_start();
if (!$_SESSION["verified"]) {
  header("Location: ../error.php");
  exit;
}

require_once('../Models/Category.php');

if (isset($_POST['category_name'])) $categoryObj->store(trim($_POST['category_name']));
$categories = $categoryObj->index();

?>



<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css' integrity='sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==' crossorigin='anonymous' />
  <title>PHP Blog</title>
</head>

<body class="pb-5">

  <header class="container my-4 d-flex justify-content-between align-items-center  " style="max-width: 30%;">
    <h2 class="text-center">Categorie</h2>

    <a href="http://localhost/php-blog/Admin/index.php" class="btn btn-secondary">Dashboard</a>
  </header>

  <main class="container my-4" style="max-width: 30%;">

    <ul class="mb-3 list-group">
      <?php foreach ($categories as $category) : ?>
        <li class="list-group-item"><?= $category->name ?></li>
      <?php endforeach; ?>
    </ul>

    <form action="formCategories.php" method="post">
      <div class="mb-3">
        <label for="category_name" class="form-label">Aggiungi Categoria</label>
        <input type="text" class="form-control" id="category_name" name="category_name">
      </div>
      <button type="submit" class="btn btn-primary px-3">Invio</button>
    </form>

  </main>

</body>

</html>