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

  <div style="max-width: 30%; margin: 0 auto;" class="my-5 py-5">

    <h1 class="text-center">Crea un nuovo acoount</h1>

    <form action="../utilities/helper.php" method="post">
      <div class="my-3">
        <label for="user_s" class="form-label">User</label>
        <input type="text" class="form-control" id="user_s" name="user_s" aria-describedby="emailHelp">
      </div>
      <div class="my-3">
        <label for="password_s" class="form-label">Password</label>
        <input type="password" class="form-control" id="password_s" name="password_s">
      </div>
      <button type="submit" class="my-3 btn btn-primary">Invia</button>
    </form>
  </div>

</body>

</html>