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
    <title>Add Product</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <a href="dashboard.php" class="btn btn-link go-back-btn ml-3 mt-3"><i class="fa fa-arrow-left"></i> Go Back</a>
    <div class="container form-container">
        <h2 class="form-title">Add Product</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category">
                    <option>Select Category</option>
                    <?php
                    $sql = "SELECT categoryName FROM categories";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option>' . $row["categoryName"] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name">
            </div>
            <div class="form-group">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter price">
            </div>
            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity">
            </div>
            <div class="form-group">
                <label for="size" class="form-label">Size</label>
                <input type="text" class="form-control" id="size" name="size" placeholder="Enter size">
            </div>
            <button type="submit" class="btn btn-primary" name="addProduct">Add Product</button>
        </form>
        <?php
        if (isset($_POST['addProduct'])) {
            $category = $_POST['category'];
            $productName = $_POST['productName'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $size = $_POST['size'];

            $sql = "INSERT INTO products (category, productName, price, quantity, size)
                    VALUES ('$category', '$productName', '$price', '$quantity', '$size')";

            if (mysqli_query($conn, $sql)) {
                echo "Product added successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

        }
        ?>
    </div>
</body>
</html>
