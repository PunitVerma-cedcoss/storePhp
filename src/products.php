<?php
use App\Util;
use App\Header;

require $_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php";
session_start();
if (!isset($_SESSION["user"])) {
    header("location:login.php");
}
if ($_SESSION["data"]["type"] != "admin" && $_SESSION["data"]["type"] != "wholeseller") {
    header("location:dashboard.php");
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
  <title>Dashboard Template · Bootstrap v5.1</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">



  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


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
  <link href="./assets/css/dashboard.css" rel="stylesheet">
  <!-- Jquery CDN -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
  <!-- Frontawesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
  <script src="js/main.js" defer></script>
</head>

<body>

  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="php/logout.php">Sign out</a>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
    <?php
        $header = new Header("products");
    ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Products</h1>
        </div>

        <form class="row row-cols-lg-auto g-3 align-items-center">
          <div class="col-12">
            <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
            <div class="input-group">
              <input type="text" class="form-control searchInput" id="inlineFormInputGroupUsername" placeholder="Enter id,name...">
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary searchBtn">Search</button>
          </div>
          <div class="col-12">
            <a class="btn btn-success" href="add-product.php">Add Product</a>
          </div>
        </form>
        <div class="table-responsive">
          <div id="render"></div>
          <?php

            $user = new Util();
            $pages = ceil($user->countPages()[0]["count"] / 5);

            $markup = '
          <nav aria-label="Page navigation example">
          <ul class="pagination">
          <li class="page-item prev"><a class="page-link" href="#">Previous</a></li>
          ';

            for ($i = 1; $i < $pages + 1; $i++) {
                $markup .= '
          <li class="page-item" data="' . ($i - 1) . '"><a class="page-link" href="#">' . $i . '</a></li>
            ';
            }

              $markup .= '
          <li class="page-item next"><a class="page-link" href="#">Next</a></li>
        </ul>
      </nav>
          ';

            echo $markup;
            ?>
          <div class="msg"></div>
        </div>
      </main>
    </div>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>