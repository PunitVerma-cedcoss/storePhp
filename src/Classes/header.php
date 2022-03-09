<?php

namespace App;

class Header
{
    public $path;
    public function __construct($path)
    {
        $this->path = $path;
        if ($_SESSION["data"]["type"] == "admin") {
            $this->adminHeader();
        } else {
            $this->userHeader();
        }
    }
    public function adminHeader()
    {
        $markup = '
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link ' . ($this->path == "dashboard" ? "active" : "" ). '" aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
            <a class="nav-link ' . ($this->path == "orders" ? "active" : "") . '" href="Orders.php">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link ' . ($this->path == "products" ? "active" : "") . '" href="products.php">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link ' . ($this->path == "editProducts" ? "active" : "") . '" href="editProduct.php">
              <span data-feather="shopping-cart"></span>
              Edit Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link ' . ($this->path == "addProduct" ? "active" : "") . '" href="add-product.php">
              <span data-feather="shopping-cart"></span>
              Add Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link ' . ($this->path == "customers" ? "active" : "") . '" href="customers.php">
              <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="home.php">
              <span data-feather="bar-chart-2"></span>
              Home
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
        ';
        echo $markup;
    }
    public function userHeader()
    {
        $markup = '
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link ' . ($this->path == "dashboard" ? "active" : "") . '" aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
          <li class="nav-item">
            <a class="nav-link" href="home.php">
              <span data-feather="layers"></span>
              shop
            </a>
          </li>
          </ul>
          </div>
        </nav>
        ';
        echo $markup;
    }
}
