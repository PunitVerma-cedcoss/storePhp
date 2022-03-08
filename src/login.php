<?php
require $_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php";
session_start();
if (isset($_SESSION["user"])) {
    if ($_SESSION["data"]["type"] == "admin") {
        header("location:dashboard.php");
    } else {
        header("location:home.php");
    }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Signin Template · Bootstrap v5.1</title>

  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="./assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin">
    <form method="post">
      <h1 class="h3 mb-3 fw-normal">Sign In</h1>

      <div class="form-floating">
        <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
      <?php
        // include "../src/vendor/autoload.php";

        use App\Util;

        if (isset($_POST["submit"])) {
            $util = new Util();
            $result =  $util->login($_POST["email"], $_POST["password"]);
            switch ($result) {
                case "notapproved":
                    echo "<div class='p-3 text-warning bg-light rounded'>Approval Pending</div>";
                    break;
                case "incorrect":
                    echo "<div class='p-3 text-danger bg-light rounded'>email/password incorrect</div>";
                    break;
                case "ok":
                    header("location:dashboard.php");
            }
        }
        ?>
      <?php
        echo isset($_GET["approval"]) ?  "<div class='p-3 text-warning bg-light rounded'>approval pending</div>" : "";
        ?>

    </form>
  </main>



</body>

</html>