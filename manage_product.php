<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

function getProducts($conn) {
    $products = array();
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
        mysqli_free_result($result);
    }

    return $products;
}

function getCategories($conn) {
    $categories = array();
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
        mysqli_free_result($result);
    }

    return $categories;
}

if (isset($_POST['editProduct'])) {
    $productId = $_POST['productId'];
    $category = $_POST['category'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];

    $update_query = "UPDATE products SET category='$category', productName='$productName', price='$price', quantity='$quantity', size='$size' WHERE id=$productId";
    mysqli_query($conn, $update_query);
}

if (isset($_GET['deleteProduct'])) {
    $productId = $_GET['deleteProduct'];
    $delete_query = "DELETE FROM products WHERE id=$productId";
    mysqli_query($conn, $delete_query);
}

$products = getProducts($conn);
$categories = getCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Products</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <a href="dashboard.php" class="btn btn-link go-back-btn ml-3 mt-3"><i class="fa fa-arrow-left"></i> Go Back</a>
    <div class="container manage-container">
        <h2 class="form-title">Manage Products</h2>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo $product['category']; ?></td>
                        <td><?php echo $product['productName']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['quantity']; ?></td>
                        <td><?php echo $product['size']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal<?php echo $product['id']; ?>">Edit</button>
                            <a href="?deleteProduct=<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php foreach ($products as $product) : ?>
        <div class="modal fade" id="editModal<?php echo $product['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                            <div class="form-group">
                                <label for="editCategory">Category</label>
                                <select class="form-control" id="editCategory" name="category">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?php echo $category['categoryName']; ?>" <?php echo ($category['id'] == $product['category']) ? 'selected' : ''; ?>><?php echo $category['categoryName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editProductName">Product Name</label>
                                <input type="text" class="form-control" id="editProductName" name="productName" value="<?php echo $product['productName']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editPrice">Price</label>
                                <input type="text" class="form-control" id="editPrice" name="price" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editQuantity">Quantity</label>
                                <input type="number" class="form-control" id="editQuantity" name="quantity" value="<?php echo $product['quantity']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editSize">Size</label>
                                <input type="text" class="form-control" id="editSize" name="size" value="<?php echo $product['size']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="editProduct">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        $(document).ready(function () {
            $('.edit-button').click(function () {
                var productId = $(this).data('product-id');
                var category = $(this).data('product-category');
                var productName = $(this).data('product-name');
                var price = $(this).data('product-price');
                var quantity = $(this).data('product-quantity');
                var size = $(this).data('product-size');

                $('#editModal' + productId + ' #editCategory').val(category);
                $('#editModal' + productId + ' #editProductName').val(productName);
                $('#editModal' + productId + ' #editPrice').val(price);
                $('#editModal' + productId + ' #editQuantity').val(quantity);
                $('#editModal' + productId + ' #editSize').val(size);
            });
        });
    </script>
</body>
</html>


