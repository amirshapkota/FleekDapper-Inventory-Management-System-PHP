<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="margin-top: 100px">
        <div class="row">
            <div class="col-md-4">
                <div class="card mx-auto">
                    <img class="card-img-top mx-auto" src="images/logo.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">Profile Info</h4>
                        <p class="card-text"><i class="fa fa-user">&nbsp;</i>Fleek Dapper</p>
                        <p class="card-text"><i class="fa fa-user">&nbsp;</i>Admin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="jumbotron">
                    <h1 class="display-5">Welcome Admin,</h1>
                    <h5>Inventory Management Portal</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Orders</h4>
                                    <p class="card-text">Create and manage orders</p>
                                    <a href="orders.php" class="btn btn-primary">Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Categories</h4>
                        <p class="card-text">Manage and add new Categories.</p>
                        <a href="add_categories.php" class="btn btn-primary">Add</a>
                        <a href="manage_categories.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Products</h4>
                        <p class="card-text">Manage and add new Products.</p>
                        <a href="add_product.php" class="btn btn-primary">Add</a>
                        <a href="manage_product.php" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
