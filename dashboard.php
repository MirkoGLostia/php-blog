<?php
include 'utilities/connection.php';
$category_id;
// Controllo della sessione
if (!$_SESSION["verified"]) {
  header("Location: error.php");
  exit;
}

// Conessione al database 
// Salvo in una variabile la lista di post dell'utente autenticato
$new_post = new Post();
$new_post->make_connection();
$posts = $new_post->index($_SESSION['user_id'], $_SESSION['category_id']);

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

  <header class="container my-4 d-flex justify-content-between ">
    <h1>Dashboard</h1>

    <div class="d-flex gap-3 align-items-center ">
      <h4><?= $_SESSION['username'] ?></h4>

      <form action="utilities/helper.php" method="post">
        <input type="hidden" name="logout" value="logout">
        <button type="submit" class="btn btn-secondary">Logout</button>
      </form>
    </div>
  </header>

  <main class="container my-4 px-5">

    <div class="my-3 py-3 d-flex gap-3 align-items-center justify-content-between ">
      <?php if ($_SESSION['category_id'] != 0) : ?>
        <h4 class="my-3 py-3">Tutti i Post in <span class=" text-info "><?= $new_category->select_category($_SESSION['category_id']) ?></span></h4>
      <?php else : ?>
        <h4 class="my-3 py-3">Tutti i Post</span></h4>
      <?php endif; ?>

      <div class="d-flex gap-3">
        <a href="dashboard/form.php" class="btn btn-primary">Crea Post</a>
        <a href="dashboard/form_categories.php" class="btn bg-info-subtle">Categorie</a>
      </div>

    </div>

    <ul class=" list-unstyled  d-flex gap-2 align-items-center ">
      <li>
        <form action="utilities/helper.php" method="post">
          <input type="hidden" name="postsByCategory" value="0">
          <button type="submit" class="badge rounded-pill text-bg-info border-0 px-4 py-3">All</button>
        </form>
      </li>
      <?php foreach ($categories as $category) : ?>
        <li>
          <form action="utilities/helper.php" method="post">
            <input type="hidden" name="postsByCategory" value="<?= $category->id ?>">
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
                <span class="badge rounded-pill text-bg-info"><?= $new_category->select_category($post->category_id) ?></span>
              </div>
              <small><?= $post->created_at ?></small>
            </div>

            <div class="d-flex my-3" style="gap: 30px">
              <div style="width: 200px; height: fit-content" class="rounded rounded-4 overflow-hidden ">
                <img style="width: 100%;" src="./storage/<?php echo $post->image ?>">
              </div>
              <p style="width: calc(100% - 230px);" class="fw-light"><?= $post->content ?></p>
            </div>

            <div class="d-flex gap-3 justify-content-end ">
              <form action="dashboard/form.php" method="post">
                <input type="hidden" name="update" value="update">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">
                <button type="submit" class="btn btn-warning ">Modifica</a>
              </form>
              <form action="utilities/helper.php" method="post">
                <input type="hidden" name="delete" value="delete">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">
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