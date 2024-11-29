<?php
session_start();
if (!$_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}

include 'db_connection.php'; // DB connection
// Fetch all users initially
$query = "SELECT * FROM tbl_users where id!=1";
$result = mysqli_query($conn, $query);
$searchResults = [];
while ($row = mysqli_fetch_assoc($result)) {
    $searchResults[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Manage Users</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Navigation -->
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
                                <a class="nav-link" href="manage_users.php">Manage Users</a>
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
                    <h2 class="mt-5">Manage Users</h2>

                    <!-- Search Form -->
                    <input type="text" id="search_query" class="form-control my-3" placeholder="Search users...">
                    <select name="status" id="status" class="form-control my-3">
                            <option value="">All</option>
                            <option value="Deactive">De-Active</option>
                            <option value="Active">Active</option>
                        </select>
                    <!-- Users Table -->
                    <table class="table table-striped" id="user_table">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Aaddhar</th>
                                
                                
                                <th>Properties Count</th>
                                <th>Action</th>
                               
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php
                            foreach ($searchResults as $user) {
                                // Fetch the number of properties for each user
                                $userId = $user['id'];
                                $propertyCountQuery = "SELECT COUNT(*) as property_count FROM property WHERE uid = $userId";
                                $propertyCountResult = mysqli_query($conn, $propertyCountQuery);
                                $propertyCountRow = mysqli_fetch_assoc($propertyCountResult);
                                $propertyCount = $propertyCountRow['property_count'];

                                // Check user status and set the appropriate button
                                $status = $user['User_Status'];
                                if ($status == 'Active') {
                                    $actionButton = "<button class='btn btn-danger' onclick='updateStatus($userId, \"Deactive\")'>Deactivate</button>";
                                } else {
                                    $actionButton = "<button class='btn btn-success' onclick='updateStatus($userId, \"Active\")'>Activate</button>";
                                }

                                echo "<tr>
                                     <td>{$user['id']}</td>
                                    <td>{$user['fname']}</td>
                                    <td>{$user['lname']}</td>
                                    <td>{$user['email']}</td>
                                    <td>{$user['mobile']}</td>
                                    <td>{$user['aadhar']}</td>
                                    <td>{$propertyCount}</td>
                                    <td>$actionButton</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- JS for updating user status -->
        <script>
            function updateStatus(userId, newStatus) {
                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: {
                        user_id: userId,
                        status: newStatus
                    },
                    success: function(response) {
                        // Reload the page or update the table to reflect the status change
                        location.reload();
                    },
                    error: function() {
                        alert("Failed to update status.");
                    }
                });
            }
        </script>

        <!-- JS for search functionality -->
        <script>
            $(document).ready(function() {
                $("#search_query").on("keyup", function() {
                    var searchQuery = $(this).val();
                    $.ajax({
                        url: "dis.php",
                        type: "POST",
                        data: {search_query: searchQuery},
                        success: function(result) {
                            $("#data").html(result);
                        }
                    });
                });
                $("#status").on("change", function() {
                    var searchQuery = $(this).val();
                    $.ajax({
                        url: "dis.php",
                        type: "POST",
                        data: {search_query: searchQuery},
                        success: function(result) {
                            $("#data").html(result);
                        }
                    });
                });
            });
            
        </script>
    </body>
</html>
