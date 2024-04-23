<?php
session_start();
if (!$_SESSION["verified"]) {
  header("Location: ../error.php");
  exit;
}

require_once('../Models/Post.php');
require_once('../Models/Category.php');

$post = isset($_GET['edit']) ? $postObj->show($_GET['edit']) : FALSE;
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

  <header class="container my-4">
    <?php if (!$post) : ?>
      <h2 class="text-center">Crea un nuovo Post</h2>
    <?php else : ?>
      <h2 class="text-center">Modifica il post: <?= $post->title ?></h2>
    <?php endif ?>
  </header>

  <main class="container my-4" style="max-width: 50%;">

    <form action="../Models/Controller.php" method="post" enctype="multipart/form-data">

      <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" value="<?= $post->title ?? '' ?>">
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Contenuto</label>
        <textarea class="form-control" id="content" name="content" aria-describedby="emailHelp" rows="10"><?= $post->content ?? '' ?></textarea>
      </div>

      <div class="mb-3 d-flex gap-3">
        <div class="flex-grow-1">
          <label for="image" class="form-label">Immagine <small>(png, jpeg, jpg)</small></label>
          <input class="form-control" name="image" type="file" id="image">
        </div>
        <div class="rounded rounded-4 overflow-hidden ">
          <img class="object-fit-cover" style="height: 100px; width: 170px;" src="../storage/placeholder.jpg">
        </div>
      </div>

      <div class="mb-4">
        <label for="category" class="form-label">Categoria</label>
        <select class="form-select" aria-label="Default select example" id="category" name="category">
          <option value="">...</option>
          <?php foreach ($categories as $category) : ?>
            <option value="<?= $category->id ?>" <?php if ($post) echo $category->id == $post->category_id ? 'selected ' : '' ?>><?= $category->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <?php if ($post) : ?>
        <input type="hidden" name="update" value="<?= $post->id ?>">
      <?php else : ?>
        <input type="hidden" name="store" value="">
      <?php endif ?>

      <button type="submit" class="btn btn-primary px-3">Invio</button>

    </form>

  </main>

</body>

</html>