<?php
session_start();

if (!$_SESSION["verified"]) {
  header("location: error.php");
  exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.css' integrity='sha512-VcyUgkobcyhqQl74HS1TcTMnLEfdfX6BbjhH8ZBjFU9YTwHwtoRtWSGzhpDVEJqtMlvLM2z3JIixUOu63PNCYQ==' crossorigin='anonymous' />
  <title>PHP Blog</title>
</head>

<body>

  <div class="container my-5">

    <h2 class="text-center">Crea un nuovo Post</h2>

    <form action="../helper.php" method="post">

      <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">Contenuto</label>
        <input type="text" class="form-control" id="content" name="content" aria-describedby="emailHelp">
      </div>

      <input type="hidden" name="create" value="create">

      <button type="submit" class="btn btn-primary">Invio</button>

    </form>

  </div>

</body>

</html>