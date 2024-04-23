<?php
session_start();
if (!$_SESSION["verified"]) {
  header("Location: ../error.php");
  exit;
}

require_once('../Models/User.php');
require_once('../Models/Category.php');
require_once('../Models/Post.php');

$category = $_GET['category'] ?? 'all';
$user = $_SESSION['user_id'];

$posts = $postObj->index($user, $category);
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

  <header class="container my-4 d-flex justify-content-between ">
    <h1>Dashboard</h1>

    <div class="d-flex gap-3 align-items-center">
      <h4 class="text-capitalize"><?= $_SESSION['username'] ?></h4>

      <form action="../Models/Controller.php" method="post">
        <input type="hidden" name="logout" value="logout">
        <button type="submit" class="btn btn-secondary">Logout</button>
      </form>
    </div>
  </header>

  <main class="container my-4 px-5">

    <div class="mt-3 d-flex gap-3 align-items-center justify-content-between ">
      <?php if ($category != 'all') : ?>
        <h4 class="my-3">Tutti i Post in <span class="text-info "><?= $categoryObj->show($category)->name ?></span></h4>
      <?php else : ?>
        <h4 class="my-3">Tutti i Post</span></h4>
      <?php endif; ?>

      <div class="d-flex gap-3">
        <a href="formPost.php" class="btn btn-primary">Crea Post</a>
        <a href="formCategories.php" class="btn bg-info-subtle">Categorie</a>
      </div>
    </div>

    <ul class="list-unstyled d-flex gap-2 align-items-center my-3 mb-4">
      <li>
        <form action="index.php" method="get">
          <input type="hidden" name="category" value="all">
          <button type="submit" class="badge rounded-pill text-bg-info border-0 px-4 py-3">All</button>
        </form>
      </li>
      <?php foreach ($categories as $category) : ?>
        <li>
          <form action="index.php" method="get">
            <input type="hidden" name="category" value="<?= $category->name ?>">
            <button type="submit" class="badge rounded-pill text-bg-info border-0 px-3 py-2"><?= $category->name ?></button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if ($posts) : ?>
      <ul class="my-3 list-group">
        <?php foreach ($posts as $post) : ?>

          <li class="px-3 py-4 list-group-item list-group-item-action">

            <div class="d-flex w-100 justify-content-between">
              <div class="d-flex gap-3 align-items-center">
                <h5 class="mb-1"><?= $post->title ?></h5>
                <span class="badge rounded-pill text-bg-info"><?= $post->name ?></span>
              </div>
              <small><?= $post->updated_at ?></small>
            </div>

            <div class="d-flex my-3" style="gap: 30px">
              <div style="width: 200px; height: fit-content" class="rounded rounded-4 overflow-hidden ">
                <img style="width: 100%;" src="../storage/<?= $post->image ?>">
              </div>
              <p style="width: calc(100% - 230px);" class="fw-light"><?= $post->content ?></p>
            </div>

            <div class="d-flex gap-3 justify-content-end ">
              <form action="formPost.php" method="get">
                <input type="hidden" name="edit" value="<?= $post->id ?>">
                <button type="submit" class="btn btn-warning ">Modifica</a>
              </form>
              <form action="../Models/Controller.php" method="post">
                <input type="hidden" name="delete" value="<?= $post->id ?>">
                <button type="submit" class="btn btn-danger ">Elimina</button>
              </form>
            </div>

          </li>

        <?php endforeach; ?>
      </ul>
    <?php else : ?>
      <p class="my-3">Non ci sono Post</p>
    <?php endif; ?>

  </main>

</body>

</html>