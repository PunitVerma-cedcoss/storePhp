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
  <script src="js/csvOperations.js" defer></script>


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
    .csv td{
      cursor:cell;
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
              <a class="nav-link active" aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <?php if ($_SESSION["data"]["type"] == "admin") { ?>
              <li class="nav-item">
                <a class="nav-link" href="Orders.php">
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
            <?php } else {
                ?>

                <li class="nav-item">
                <a class="nav-link" href="Orders.php">
                  <span data-feather="file"></span>
                  My Orders
                </a>
              </li>
                <?php
            }
            ?>
                <li class="nav-item">
                <a class="nav-link" href="home.php">
                  <span data-feather="file"></span>
                  Shop
                </a>
              </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
          <?php if ($_SESSION["data"]["type"] == "admin") { ?>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary import"  data-bs-toggle="modal" data-bs-target="#myModal">Import</button>
                <button type="button" class="btn btn-sm btn-outline-secondary export">Export</button>
              </div>
              <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
              </button>
            </div>
          <?php } ?>
        </div>
                <!-- The Modal -->
        <div class="modal fade" id="myModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Modal Heading</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <!-- Modal body -->
              <div class="modal-body">
                <form enctype="multipart/form-data">
                <div class="form-control">
                  <label for="file">
                    <input type="file" accept=".csv" id="upload"/>
                  </label>
                </div>
              </form>
              <div class="renderCsv table-responsive" style="height:50vh;"></div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" class="btn btn-primary read">Upload</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
        <?php
        if ($_SESSION["type"] == "admin") {
            ?>
          <h2>Recent Products</h2>
          <div class="table-responsive">
            <?php
            $util = new Util();
            $result =  $util->getProducts();
            $keys = array_keys($result[0]);
            $markup = "
            <table  class='table table-striped table-sm'>
              <thead>
                <tr>
          ";
            foreach ($keys as $k) {
                $markup .= "<th scope='col'>" . $k . "</th>";
            }
            $markup .= "</tr>
                <tbody>
          ";
            foreach ($result as $product) {
                $ctr = 0;
                $markup .= "<tr>";
                foreach ($product as $details) {
                    if ($ctr < 7) {
                        $markup .= "<td>" . $details . "</td>";
                    } else {
                        $markup .= "<td>";
                        for ($i = 0; $i < (int) $details; $i++) {
                            $markup .= "<i class='fa fa-star'></i>";
                        }
                        $markup .= "</td>";
                    }
                    $ctr++;
                }
                $markup .= "</tr>";
            }
            $markup .= "</tbody>
            </table>    
          ";
            echo $markup;
            ?>
          </div>
          <h2>Recent Users</h2>
          <div class="table-responsive">
            <?php
            $util = new Util();
            $result =  $util->getUsers();
            $keys = array_keys($result[0]);
            $markup = "
            <table  class='table table-striped table-sm'>
              <thead>
                <tr>
          ";
            foreach ($keys as $k) {
                $markup .= "<th scope='col'>" . $k . "</th>";
            }
            $markup .= "<th scope='col'>Delete</th>";
            $markup .= "</tr>
                <tbody>
          ";

            $id = 0;
            foreach ($result as $product) {
                $ctr = 0;
                $markup .= "<tr>";
                if ($product["email"] != "admin@store.com") {
                    foreach ($product as $details) {
                        if ($ctr == 0) {
                            $markup .= "<td>" . $id . "</td>";
                        } elseif ($ctr == 2) {
                            $markup .= "<td data='" . $details . "'>" . $details . "</td>";
                        } elseif ($ctr < 5) {
                            $markup .= "<td>" . $details . "</td>";
                        } else {
                            if ($details == 1) {
                                $markup .= "<td><button class='status btn btn-danger'>Disapprove</button></td>";
                            } else {
                                $markup .= "<td><button class='status btn btn-success'>approve</button></td>";
                            }
                            $markup .= "<td><button class='btn delete btn-danger btn-sm'>delete</button></td>";
                        }
                        $ctr++;
                    }
                }
                $id++;
                $markup .= "</tr>";
            }
            $markup .= "</tbody>
            </table>    
          ";
            echo $markup;
            ?>
            <?php
        } else {
            ?>

            <!-- show profile if user is not admin -->

            <form class="row g-3 updateProfileForm" method="post">
              <div class="col-lg-2 col-md-4 d-flex justify-content-center align-items-center ">
                <div class="profilepic bg-primary rounded-circle d-flex justify-content-center align-items-center text-white font-weight-bold display-2" style="width: 100px;height:100px">
                  <p><?php echo $_SESSION["data"]["userName"][0] ?></p>
                </div>
              </div>
              <div class="col-lg-10 col-md-8">
                <label for="inputEmail4" class="form-label">User Name</label>
                <input type="text" name="userName" class="form-control" id="inputEmail4" value="<?php echo $_SESSION["data"]["userName"]; ?>" required>
              </div>
              <div class="col-md-12">
                <label for="inputPassword4" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" id="inputPassword4" value="<?php echo $_SESSION["data"]["email"]; ?>" required>
              </div>
              <div class="col-12">
                <label for="inputAddress" class="form-label">Password</label>
                <input type="text" name="password" value="<?php echo $_SESSION["data"]["password"]; ?>" class="form-control" id="inputAddress" required>
              </div>
              <!-- <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Check me out
              </label>
            </div>
          </div> -->
              <div class="col-12">
                <button type="submit" id="updateProfile" name="updateProfile" class="btn btn-primary">Update
                  Profile</button>
                <div class="profileMsg"></div>
              </div>
              <!-- handling update profile button -->
              <?php
                if (isset($_POST["updateProfile"])) {
                    print_r($_POST);
                }
                ?>
            </form>

            <?php
        }
        ?>
          </div>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"> -->
  </script>
</body>

</html>