<?php
session_start();

// var_dump($_POST['user']);
// var_dump($_POST['password']);

echo "Favorite animal is " . $_SESSION["verified"] . ".";


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
    <h1>Homepage</h1>

    <p>Pubblica</p>

    <a href="http://localhost/php-blog/login.php" class="btn btn-primary">Login</a>
  </div>
</body>

</html>