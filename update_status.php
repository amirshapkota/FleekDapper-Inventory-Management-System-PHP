<?php
include("db.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST["orderId"];
    $newStatus = $_POST["newStatus"];

    $updateQuery = "UPDATE orders SET status = '$newStatus' WHERE order_id = $orderId";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo "success";
    } else {
        echo "error";
    }
}

?>
