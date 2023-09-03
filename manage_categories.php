<?php
session_start();
include 'db.php';

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
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

if (isset($_POST['editCategory'])) {
    $categoryId = $_POST['categoryId'];
    $categoryName = $_POST['categoryName'];
    $categoryType = $_POST['categoryType'];

    $update_query = "UPDATE categories SET categoryName='$categoryName', categoryType='$categoryType' WHERE id=$categoryId";
    mysqli_query($conn, $update_query);
}

if (isset($_GET['deleteCategory'])) {
    $categoryId = $_GET['deleteCategory'];
    $delete_query = "DELETE FROM categories WHERE id=$categoryId";
    mysqli_query($conn, $delete_query);
}

$categories = getCategories($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Categories</title>
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
        <h2 class="form-title">Manage Categories</h2>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Category Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><?php echo $category['categoryName']; ?></td>
                        <td><?php echo $category['categoryType']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal<?php echo $category['id']; ?>">Edit</button>
                            <a href="?deleteCategory=<?php echo $category['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php foreach ($categories as $category) : ?>
        <div class="modal fade" id="editModal<?php echo $category['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="categoryId" value="<?php echo $category['id']; ?>">
                            <div class="form-group">
                                <label for="editCategoryName">Category Name</label>
                                <input type="text" class="form-control" id="editCategoryName" name="categoryName" value="<?php echo $category['categoryName']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editCategoryType">Category Type</label>
                                <input type="text" class="form-control" id="editCategoryType" name="categoryType" value="<?php echo $category['categoryType']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="editCategory">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        $(document).ready(function () {
            $('.edit-button').click(function () {
                var categoryId = $(this).data('category-id');
                var categoryName = $(this).data('category-name');
                var categoryType = $(this).data('category-type');

                $('#editModal' + categoryId + ' #editCategoryName').val(categoryName);
                $('#editModal' + categoryId + ' #editCategoryType').val(categoryType);
            });
        });
    </script>
</body>
</html>
