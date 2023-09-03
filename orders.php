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
    <title>Manage Orders</title>
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
        <button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#addOrder" style="margin-left:90%">Add Order</button>
        <h2 class="form-title">Manage Orders</h2>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("db.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $customerName = $_POST["customerName"];
                    $product = $_POST["product"];
                    $price = floatval($_POST["price"]);
                    $quantity = intval($_POST["quantity"]);
                    $totalAmount = $price * $quantity;

                    $insertQuery = "INSERT INTO orders (customer_name, product_name, price, quantity, total_amount, status) VALUES ('$customerName', '$product', $price, $quantity, $totalAmount, 'Processing')";
                    $result = mysqli_query($conn, $insertQuery);
                    if ($result) {
                        echo "<script>alert('Order added successfully.');</script>";
                    } else {
                        echo "<script>alert('Error adding order: " . mysqli_error($conn) . "');</script>";
                    }
                }

                // Query to retrieve orders with statuses other than "Cancelled" and "Finished" from the database
$query = "SELECT * FROM orders WHERE status NOT IN ('Cancelled', 'Finished')";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Display rows with statuses other than "Cancelled" and "Finished"
        echo '<tr>';
        echo '<td>' . $row['order_id'] . '</td>';
        echo '<td>' . $row['customer_name'] . '</td>';
        echo '<td>' . $row['product_name'] . '</td>';
        echo '<td>Rs. ' . $row['price'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>Rs. ' . $row['total_amount'] . '</td>';
        echo '<td class="status">' . $row['status'] . '</td>';
        echo '<td>';
        echo '<div class="dropdown">';
        echo '<button class="btn btn-primary edit-button" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo 'Change Status &nbsp;<i class="fa fa-caret-down"></i>';
        echo '</button>';
        echo '<div class="dropdown-menu" aria-labelledby="statusDropdown">';
        echo '<a class="dropdown-item change-status" href="#">Processing</a>';
        echo '<a class="dropdown-item change-status" href="#">Cancelled</a>';
        echo '<a class="dropdown-item change-status" href="#">Finished</a>';
        echo '</div>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
    
    // Free result set
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Query to retrieve orders with "Cancelled" and "Finished" statuses from the database
$specialStatusQuery = "SELECT * FROM orders WHERE status IN ('Cancelled', 'Finished')";
$specialStatusResult = mysqli_query($conn, $specialStatusQuery);

if ($specialStatusResult) {
    while ($row = mysqli_fetch_assoc($specialStatusResult)) {
        // Display rows with "Cancelled" and "Finished" statuses
        echo '<tr>';
        echo '<td>' . $row['order_id'] . '</td>';
        echo '<td>' . $row['customer_name'] . '</td>';
        echo '<td>' . $row['product_name'] . '</td>';
        echo '<td>Rs. ' . $row['price'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>Rs. ' . $row['total_amount'] . '</td>';
        echo '<td class="status">' . $row['status'] . '</td>';
        echo '<td>';
        echo '<div class="dropdown">';
        echo '<button class="btn btn-primary edit-button" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo 'Change Status &nbsp;<i class="fa fa-caret-down"></i>';
        echo '</button>';
        echo '<div class="dropdown-menu" aria-labelledby="statusDropdown">';
        echo '<a class="dropdown-item change-status" href="#">Processing</a>';
        echo '<a class="dropdown-item change-status" href="#">Cancelled</a>';
        echo '<a class="dropdown-item change-status" href="#">Finished</a>';
        echo '</div>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }

    // Free result set
    mysqli_free_result($specialStatusResult);
} else {
    echo "Error: " . mysqli_error($conn);
}

                ?>
            </tbody>
        </table>

        <div class="modal fade" id="addOrder" tabindex="-1" role="dialog" aria-labelledby="addOrderLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderLabel">Add Order</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="customerName">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" name="customerName">
                            </div>
                            <div class="form-group">
                                <label for="product">Product</label>
                                <select class="form-control" id="product" name="product">
                                    <?php
                                    $productQuery = "SELECT productName FROM products";
                                    $productResult = mysqli_query($conn, $productQuery);

                                    if ($productResult) {
                                        while ($productRow = mysqli_fetch_assoc($productResult)) {
                                            echo '<option>' . $productRow['productName'] . '</option>';
                                        }
                                    } else {
                                        echo '<option>Product 1</option>';
                                        echo '<option>Product 2</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
    $(document).ready(function() {
        $(".change-status").on("click", function() {
            var newStatus = $(this).text();
            var orderId = $(this).closest("tr").find("td:first").text();
            updateOrderStatus(orderId, newStatus);
            $(this).closest("tr").find(".status").text(newStatus);
        });

        function updateOrderStatus(orderId, newStatus) {
            $.ajax({
                type: "POST",
                url: "update_status.php",
                data: {
                    orderId: orderId,
                    newStatus: newStatus
                },
                success: function(response) {
                    if (response === "success") {
                        alert("Order status updated successfully.");
                    } else {
                        alert("Error updating order status.");
                    }
                }
            });
        }
    });
</script>

    
</body>
</html>


