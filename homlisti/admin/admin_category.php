<?php
session_start();
ob_start(); // Start output buffering
include 'db_connection.php';
if (!$_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission for adding a new category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $cname = mysqli_real_escape_string($conn, $_POST['cname']);

    // Insert new category
    $sql = "INSERT INTO tblcategory (cname) VALUES ('$cname')";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Category added successfully.");</script>';
        header("Location: admin_category.php");
        exit();
    } else {
        echo '<script>alert("Error adding category: ' . mysqli_error($conn) . '");</script>';
    }
}

// Handle category update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $cname = mysqli_real_escape_string($conn, $_POST['cname']);

    // Update category
    $sql = "UPDATE tblcategory SET cname = '$cname' WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Category updated successfully.");</script>';
        header("Location: admin_category.php");
        exit();
    } else {
        echo '<script>alert("Error updating category: ' . mysqli_error($conn) . '");</script>';
    }
}

// Handle category deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete category
    $sql = "DELETE FROM tblcategory WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Category deleted successfully.");</script>';
        header("Location: admin_category.php");
        exit();
    } else {
        echo '<script>alert("Error deleting category: ' . mysqli_error($conn) . '");</script>';
    }
}

// Fetch all categories for display
$categories = mysqli_query($conn, "SELECT * FROM tblcategory");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Manage Categories</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-2 d-none d-md-block sidebar position-fixed vh-100" style="background-color: #d3d3d3 ;">
                    <div class="sidebar-sticky">
                        <h4 class="sidebar-heading">Admin Menu</h4>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="admin_category.php">Category</a>
                            </li>
                            <li class="nav-item">
                                <select class="form-control" id="managePropertySelect" onchange="location = this.value;">
                                    <option selected disabled>Manage Property:</option>
                                    <option value="admin_verify.php?status=pending">Pending Properties</option>
                                    <option value="admin_verify.php?status=allowed">Allowed Properties</option>
                                    <option value="admin_verify.php?status=denied">Denied Properties</option>
                                </select>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_users.php">Manage Users</a> <!-- New Manage Users Link -->
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="ManageFeedback.php">Manage Feedback</a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" href="changePassword.php">Change Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="container mt-5">
                        <h2>Manage Property Categories</h2>

                        <!-- Add new category form -->
                        <form method="POST" action="admin_category.php">
                            <div class="form-group">
                                <label for="cname">Category Name</label>
                                <input type="text" class="form-control" name="cname" required>
                            </div>
                            <button type="submit" name="add_category" class="btn btn-success">Add Category</button>
                        </form>

                        <hr>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($categories)) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['cname']; ?></td>
                                        <td>
                                            <a href="admin_category.php?edit=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                            <a href="admin_category.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <!-- Handle edit form if an edit is triggered -->
                        <?php
                        if (isset($_GET['edit'])) {
                            $id = $_GET['edit'];
                            $edit_category = mysqli_query($conn, "SELECT * FROM tblcategory WHERE id = '$id'");
                            $row = mysqli_fetch_assoc($edit_category);
                            ?>
                            <hr>
                            <h3>Edit Category</h3>
                            <form method="POST" action="admin_category.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="form-group">
                                    <label for="cname">Category Name</label>
                                    <input type="text" class="form-control" name="cname" value="<?php echo $row['cname']; ?>" required>
                                </div>
                                <button type="submit" name="update_category" class="btn btn-primary">Update Category</button>
                            </form>
                        <?php } ?>
                    </div>
                </main>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>

<?php
mysqli_close($conn);
ob_end_flush();
?>
