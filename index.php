<?php
include 'utilities/connection.php';

// Conessione al database 
// Salvo in una variabile la lista completa dei post
$connection = new Crud();
$connection->make_connection();
$posts = $connection->index('posts', true);

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

  <header class="container my-4 d-flex justify-content-between align-items-center ">
    <h1>Homepage</h1>

    <a href="login.php" class="btn btn-secondary">Login</a>
  </header>

  <main class="container my-4 px-5">

    <h4 class="my-3 py-3">Tutti i Post</h4>

    <ul class="my-3 list-group">
      <?php foreach ($posts as $post) : ?>

        <li class="px-3 py-4 list-group-item list-group-item-action">

          <div class="d-flex w-100 justify-content-between">
            <div class="d-flex align-items-center gap-3">
              <h5 class="mb-1"><?= $post->title ?></h5>
              <span><?= "($post->user_id)" ?></span>
            </div>
            <small><?= $post->created_at ?></small>
          </div>

          <p class="m-0 fw-light"><?= $post->content ?></p>

        </li>

      <?php endforeach; ?>
    </ul>

  </main>

</body>

</html>