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

  <header class="container my-5 d-flex justify-content-between ">
    <h1>Dashboard</h1>

    <form action="helper.php" method="post">
      <input type="hidden" name="logout" value="logout">
      <button type="submit" class="btn btn-primary">logout</button>
    </form>
  </header>

  <main class="container my-5">

    <a href="dashboard/create.php">Crea Post</a>

  </main>
</body>

</html>