<?php
include '../utilities/connection.php';

// Controllo della sessione
if (!$_SESSION["verified"]) {
  header("Location: ../error.php");
  exit;
}

$connection = new Crud();
$connection->make_connection();
if (isset($_POST['post_id'])) $post = $connection->select($_POST['post_id']);


$connection = new Category();
$connection->make_connection();
$categories = $connection->index();
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
    <?php if (empty($post)) : ?>
      <h2 class="text-center">Crea un nuovo Post</h2>
    <?php else : ?>
      <h2 class="text-center">Modifica il Post: <?= $post['title'] ?></h2>
    <?php endif ?>
  </header>

  <main class="container my-4" style="max-width: 50%;">

    <form action="../utilities/helper.php" method="post">

      <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" value="<?= $post['title'] ?? '' ?>">
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Contenuto</label>
        <textarea class="form-control" id="content" name="content" aria-describedby="emailHelp" rows="10"><?= $post['content'] ?? '' ?></textarea>
      </div>
      <select class="mb-3 form-select" aria-label="Default select example" name="category_id">
        <option value="">...</option>
        <?php foreach ($categories as $category) : ?>
          <option value="<?= $category->id ?>" <?php if (!empty($post)) echo $post['category_id'] === $category->id ? 'selected ' : ''; ?>><?= $category->name ?></option>
        <?php endforeach; ?>
      </select>

      <?php if (empty($post)) : ?>
        <input type="hidden" name="create" value="create">
      <?php else : ?>
        <input type="hidden" name="update" value="update">
        <input type="hidden" name="post_id" value="<?php echo $_POST['post_id'] ?>">
      <?php endif ?>

      <button type="submit" class="btn btn-primary px-3">Invio</button>

    </form>

  </main>

</body>

</html>