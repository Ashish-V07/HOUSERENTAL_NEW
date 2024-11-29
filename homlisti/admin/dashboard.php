<?php
session_start();
if (!$_SESSION['email'] == "22bmiit150@gmail.com") {
     header("Location: /houserental-master/homlisti/my-account/index.php"); // Redirect to login if not logged in
    exit();
}

include 'db_connection.php'; // Include your DB connection

function getTotalProperties($conn) {
    $query = "SELECT COUNT(*) as count FROM property";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'];
}

function getPendingVerifications($conn) {
    $query = "SELECT COUNT(*) as count FROM property WHERE status = 1";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'];
}

function getTotalUsers($conn) {
    $query = "SELECT COUNT(*) as count FROM tbl_users";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Admin Dashboard</title>
        <style>
            body{
                 
                 height :100vh;
            }
        </style>
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

                            <!-- Manage Property Selection Dropdown -->
                            <!-- Manage Property Selection Dropdown -->
                            <li class="nav-item" >
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
                    <h2>Dashboard</h2>

                    <!-- Dashboard Summary -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Total Properties</h5>
                                    <p class="card-text"><?php echo getTotalProperties($conn); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Verifications</h5>
                                    <p class="card-text"><?php echo getPendingVerifications($conn); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Total Users</h5>
                                    <p class="card-text"><?php echo getTotalUsers($conn); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Properties Table -->
                    <h3>Recent Properties</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Property ID</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Rent</th>
                            </tr>
                        </thead>
                        <tbody>     
                            <?php
// Fetch and display recent properties from the database
                            $query = "SELECT * FROM property ORDER BY pid DESC LIMIT 5";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['pid']}</td>
                                    <td>{$row['adress']}</td>
                                    <td>{$row['status']}</td>
                                    <td>{$row['rent']}</td>
                                  </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
