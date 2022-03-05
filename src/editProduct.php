<?php
include "classes/utils.php";
session_start();
if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] != "admin@store.com") {
        header("location:dashboard.php");
    }
}
if (isset($_GET["productId"])) {
    $x = $_GET["productId"];
    if (!is_numeric($x)) {
        header("location:products.php");
    }
}
$util2 = new Util();
$data = $util2->getProductById($_GET["productId"])[0];
if (!$data) {
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
    <!-- Jquery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
    <script src="js/main.js" defer></script>
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
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search" required>
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
                            <a class="nav-link" aria-current="page" href="add-product.php">
                                <span data-feather="home"></span>
                                AddProduct
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="home"></span>
                                Edit Product
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
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
                            <a class="nav-link" href="customers.php">
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
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Update Product</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>
                <?php
                $images = explode(",", $data["product_images"]);
                ?>
                <form class="row g-3" method="post" enctype="multipart/form-data">
                    <?php
                    if (count($images) > 0) {
                        $m = '
                    <div class="col-md-12">
                   
                    ';
                        for ($i = 0; $i < count($images); $i++) {
                            $m .= '<img src="../' . $images[$i] . '" width="150" height="150"/>';
                        }
                    }

                    $m .= " </div>";
                    echo $m;
                    ?>
                    <div class="col-md-12">
                        <label for="images" class="form-label">Product Images</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" id="imagesu" multiple required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Product Name</label>
                        <input type="text" value="<?php echo $data["product_name"]; ?>" name="productName" class="form-control" id="inputEmail4" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Product Price</label>
                        <input type="text" value="<?php echo $data["product_price"]; ?>" name="productPrice" class="form-control" id="inputPassword4" required>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Product Quantity</label>
                        <input type="text" value="<?php echo $data["product_quantity"]; ?>" name="productQuantity" class="form-control" id="inputAddress" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Product Rating</label>
                        <input type="text" value="<?php echo $data["product_rating"]; ?>" name="productRating" min="1" class="form-control" id="inputCity" required>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Product Category</label>
                        <div class="d-flex">
                            <select id="inputState" name="productCategory" class="form-select categories" required>
                                <option selected>choose</option>
                                <?php
                                $util1 = new Util();
                                foreach ($util1->getCategories() as $product) {
                                    if ($data["product_category"] == $product["category"]) {
                                        echo '<option value="' . $product["category"] . '" selected>' . $product["category"] . '</option>';
                                    } else {

                                        echo '<option value="' . $product["category"] . '">' . $product["category"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <a href="#" class="btn btn-primary ms-2 px-3 addCategory">+</a>
                        </div>
                        <div class="col-md-12 mt-2 d-flex addCategories d-none">
                            <input type="text" name="addcategory" class="form-control" id="inputCity">
                            <a href="#" class="btn btn-primary ms-2 btnAddCategory">Add Category</a>
                        </div>

                        <div class="col-md-12 mt-2 d-flex addCategories d-none">
                            <input type="text" name="addcategory" class="form-control" id="inputCity">
                            <a href="#" class="btn btn-primary ms-2 btnAddCategory">Add Category</a>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <label for="productDesc" class="form-label">Product Description</label>
                        <textarea name="productDesc" rows="3" class="form-control" id="productDesc" required><?php echo $data["product_desc"]; ?> </textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="productTags" class="form-label">Product Tags</label>
                        <input text="text" name="productTags" value="<?php echo $data["product_tags"]; ?>" rows="3" class="form-control" id="productTags" required></input>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
                    </div>
                    <div class="notification"></div>
                    <?php
                    $images_paths = [];
                    function is_image($path)
                    {
                        $a = getimagesize($path);
                        $image_type = $a[2];

                        if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
                            return true;
                        }
                        return false;
                    }
                    // if click add product
                    if (isset($_POST["submit"])) {

                        $ctr = 0;
                        for ($i = 0; $i < count($_FILES["images"]["name"]); $i++) {
                            if (is_image($_FILES["images"]["tmp_name"][$i]))
                                $ctr++;
                        }
                        if ($ctr == count($_FILES["images"]["name"])) {
                            //all images are validated
                            for ($i = 0; $i < count($_FILES["images"]["name"]); $i++) {
                                $target_dir = "images/";
                                $image_format = explode(".", basename($_FILES["images"]["name"][$i]))[1];
                                $target_file = $target_dir . random_int(0, 10000000000000000) . "." . $image_format;
                                if (move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
                                    array_push($images_paths, $target_file);
                                }
                            }
                        }
                        $imagesString = implode(",", $images_paths);
                        $util = new Util();
                        $result =  $util->updateProduct($_GET["productId"], $_POST["productName"], $_POST["productPrice"], $_POST["productQuantity"], $_POST["productCategory"], $imagesString, $_POST["productDesc"], $_POST["productRating"], $_POST["productTags"]);
                        if ($result) {
                            echo "<div class='p-3 rounded-lg text-success bg-light notification'>product added successfully</div>";
                        } else {
                            echo "<div class='p-3 rounded-lg text-danger bg-light notification'>error adding product</div>";
                        }
                    }
                    ?>
                </form>
            </main>
        </div>
    </div>


    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>