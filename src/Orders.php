<?php
use App\Util;

require $_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php";
session_start();
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
    <!-- Frontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <!-- Bootstrap core CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Jquery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" defer></script>
    <script src="js/main.js" defer></script>
    <script src="js/Orders.js" defer></script>

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
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <?php if ($_SESSION["data"]["type"] == "admin") { ?>
              <li class="nav-item">
                <a class="nav-link active" href="Orders.php">
                  <span data-feather="file"></span>
                  Orders
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="products.php">
                  <span data-feather="shopping-cart"></span>
                  Products
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="add-product.php">
                  <span data-feather="shopping-cart"></span>
                  Add Products
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="users"></span>
                  Customers
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="bar-chart-2"></span>
                  Reports
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">
                  <span data-feather="layers"></span>
                  Integrations
                </a>
              </li>
                  <?php
            } else {
                ?>

                <li class="nav-item">
                <a class="nav-link active" href="Orders.php">
                  <span data-feather="file"></span>
                  My Orders
                </a>
              </li>
                <?php
            }
            ?>
          </ul>
        </div>
      </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">My Orders</h1>
                </div>
                <div class="table-responsive">
                    <?php
                    $ctr = 0;
                    if ($_SESSION["data"]["type"] == "admin") {
                        $util = new Util();
                        foreach ($util->getOrders() as $order) {
                            ?>
                            <p class="fs-5"><?php echo $order["fname"]; ?>'s order</p>
                            <button data-bs-toggle="collapse" class="btn btn-primary" data-bs-target="#demo<?php echo $order["id"]; ?>">show Details</button>
                            <div id="demo<?php echo $order["id"]; ?>" class="collapse">
                            <div class="details bg-primary text-white border p-2 m-2 shadow-sm rounded" style="max-width: 50%;">
                                <p class="ms-0 p-0 m-0">date of Order : <?php echo $order["order_date"]; ?></p>
                                <p class="ms-0 p-0 m-0">address : <?php echo $order["address"]; ?></p>
                                <p class="ms-0 p-0 m-0">address 2 : <?php echo $order["address2"]; ?></p>
                                <p class="ms-0 p-0 m-0">country : <?php echo $order["country"]; ?></p>
                                <p class="ms-0 p-0 m-0">state : <?php echo $order["State"]; ?></p>
                                <p class="ms-0 p-0 m-0">zip : <?php echo $order["zip"]; ?></p>
                                <p class="ms-0 p-0 m-0">payment Method : <?php echo $order["payment_mode"]; ?></p>
                                <p class="ms-0 p-0 m-0">name on Card : <?php echo $order["name_on_card"]; ?></p>
                                <p class="ms-0 p-0 m-0">card No : <?php echo $order["card_no"]; ?></p>
                                <p class="ms-0 p-0 m-0">expiration : <?php echo $order["expiration"]; ?></p>
                                <p class="ms-0 p-0 m-0">cvv : <?php echo $order["cvv"]; ?></p>
                            </div>
                            </div>
                            <label for="status">
                            <select name="status" data="<?php echo $order["id"]; ?>" class="form-select m-2 changeStatus">
                              <option value="none" class="">Change Status</option>
                              <option value="pending" class="text-warning" <?php echo $order["status"]=="pending" ? "selected":"false" ?>>Progress</option>
                              <option value="delivered" class="text-success" <?php echo $order["status"]=="delivered" ? "selected":"false" ?>>Delivered</option>
                              <option value="shift" class="text-primary" <?php echo $order["status"]=="shift" ? "selected":"false" ?>>shift</option>
                            </select>
                            </label>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Product Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $total = 0;
                                    foreach ($util->getProductDetails($order["products"]) as $cartDetails) {
                                        $total += (int) $cartDetails["quantity"] * $cartDetails["product_price"];
                                        ?>
                                        <tr>
                                            <td><?php echo $cartDetails["id"]; ?></td>
                                            <td><?php echo $cartDetails["product_name"]; ?></td>
                                            <td><?php echo $cartDetails["product_price"]; ?></td>
                                            <td><?php echo $cartDetails["quantity"]; ?></td>
                                            <td><?php echo $cartDetails["quantity"] * $cartDetails["product_price"]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-success">Grand Total</td>
                                        <td colspan="1" class="fs-5 font-weight-bold text-primary"><?php echo $total; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <?php
                        }
                        ?>
                </div>
                        <?php
                    } else {
                        $util = new Util();
                        foreach ($util->getOrdersByName() as $order) {
                            ?>
                                                        <p class="fs-5"><?php echo $order["fname"]; ?>'s order</p>
                            <div class="details bg-primary text-white border p-2 m-2 shadow-sm rounded" style="max-width: 50%;">
                                <p class="ms-0 p-0 m-0">date of Order : <?php echo $order["order_date"]; ?></p>
                                <p class="ms-0 p-0 m-0">address : <?php echo $order["address"]; ?></p>
                                <p class="ms-0 p-0 m-0">address 2 : <?php echo $order["address2"]; ?></p>
                                <p class="ms-0 p-0 m-0">country : <?php echo $order["country"]; ?></p>
                                <p class="ms-0 p-0 m-0">state : <?php echo $order["State"]; ?></p>
                                <p class="ms-0 p-0 m-0">zip : <?php echo $order["zip"]; ?></p>
                                <p class="ms-0 p-0 m-0">payment Method : <?php echo $order["payment_mode"]; ?></p>
                                <p class="ms-0 p-0 m-0">name on Card : <?php echo $order["name_on_card"]; ?></p>
                                <p class="ms-0 p-0 m-0">card No : <?php echo $order["card_no"]; ?></p>
                                <p class="ms-0 p-0 m-0">expiration : <?php echo $order["expiration"]; ?></p>
                                <p class="ms-0 p-0 m-0">cvv : <?php echo $order["cvv"]; ?></p>
                            </div>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Product Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $total = 0;
                                    foreach ($util->getProductDetails($order["products"]) as $cartDetails) {
                                        $total += (int) $cartDetails["quantity"] * $cartDetails["product_price"];
                                        ?>
                                        <tr>
                                            <td><?php echo $cartDetails["id"]; ?></td>
                                            <td><?php echo $cartDetails["product_name"]; ?></td>
                                            <td><?php echo $cartDetails["product_price"]; ?></td>
                                            <td><?php echo $cartDetails["quantity"]; ?></td>
                                            <td><?php echo $cartDetails["quantity"] * $cartDetails["product_price"]; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-success">Grand Total</td>
                                        <td colspan="1" class="fs-5 font-weight-bold text-primary"><?php echo $total; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                        }
                    }
                    ?>


        </div>
        </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="/src/node_modules/bootstrap/dist/js/bootstrap.bundle.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
</body>

</html>