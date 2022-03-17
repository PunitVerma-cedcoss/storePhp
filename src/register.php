<?php

use App\User;

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
if (!isset($_SESSION["user"])) {
    if (isset($_POST["submit"])) {
        $user = new User($_POST["name"], $_POST["password"], $_POST["email"]);
        if ($user->addUser()) {
            echo "user succefully added";
            header("location:login.php?approval=false");
        }
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
    <title>Signup Template · Bootstrap v5.1</title>

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
            <h1 class="h3 mb-3 fw-normal">Sign Up</h1>

            <div class="form-floating rounded-top ">
                <input type="name" name="name" class="form-control rounded-0 rounded-top" id="floatingInput" placeholder="name" required>
                <label for="floatingInput">Name</label>
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control rounded-0" id="floatingInput1" placeholder="name@example.com" required>
                <label for="floatingInput1">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control m-0 rounded-0" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <div class="form-floating">
                <input type="password" name="rpassword" class="form-control" id="floatingPassword1" placeholder="Repeat Password" required>
                <label for="floatingPassword1">Repeat Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
        </form>
    </main>



</body>

</html>