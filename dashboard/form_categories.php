<?php
include '../utilities/connection.php';

// Controllo della sessione
if (!$_SESSION["verified"]) {
  header("Location: ../error.php");
  exit;
}

$new_category = new Category();
$new_category->make_connection();
$categories = $new_category->index();
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

    <a href="http://localhost/php-blog/dashboard.php" class="btn btn-secondary">Dashboard</a>
  </header>

  <main class="container my-4" style="max-width: 30%;">

    <ul class="mb-3 list-group">
      <?php foreach ($categories as $category) : ?>
        <li class="list-group-item"><?= $category->name ?></li>
      <?php endforeach; ?>
    </ul>

    <form action="../utilities/helper.php" method="post">

      <div class="mb-3">
        <label for="name" class="form-label">Aggiungi Categoria</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>

      <input type="hidden" name="categories" value="categories">

      <button type="submit" class="btn btn-primary px-3">Invio</button>

    </form>

  </main>

</body>

</html>