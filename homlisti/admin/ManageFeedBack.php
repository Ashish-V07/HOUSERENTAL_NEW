<?php
session_start();
include 'db_connection.php';

// Check if admin is logged in (optional, depending on your authentication system)
if (!$_SESSION['email'] == "22bmiit150@gmail.com") {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}

// Fetch all feedback from the database
$sql = "SELECT fid, uid, type, descr, date, status FROM tblfeedback";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Admin Dashboard - Feedbacks</title>
        <style></style>
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
                    <h2 class="mt-5">Manage Feedbacks</h2>
                    <br>
                    <form id="searchForm" class="form-inline mb-3">
                        <label for="status" class="mr-2">Filter by Status:</label>
                        <select name="status" id="status" class="form-control mr-3">
                            <option value="">All</option>
                            <option value="UNDER REVIEW">UNDER REVIEW</option>
                            <option value="DONE">DONE</option>
                        </select>

                        <label for="type" class="mr-2">Filter by Type:</label>
                        <select name="type" id="type" class="form-control mr-3">
                            <option value="">All</option>
                          
                            <option value="SUGGESTION">Suggestion</option>
                              <option value="BUG REPORT">Bug Report</option>
                            <option value="COMPLIMENT">Compliment</option>
                            <option value="REQUEST">Request</option>
                        </select>

                        <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
                    </form>
<br>
                    <!-- Feedbacks Table -->
                    <table class="table table-striped" id="feedback_table">
                        <thead>
                            <tr>
                                <th>Feedback ID</th>
                                <th>User ID</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                // Fetch and display each row of the result
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['fid'] . "</td>";
                                    echo "<td>" . $row['uid'] . "</td>";
                                    echo "<td>" . $row['type'] . "</td>";
                                    echo "<td>" . $row['descr'] . "</td>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    // Check if status is 'underreview' to show the 'Done' button
                                    if ($row['status'] == 'UNDER REVIEW') {
                                        echo "<td><button class='btn btn-success done-btn' id='btnDone' data-fid='" . $row['fid'] . "' data-uid='" . $row['uid'] . "' data-type='" . $row['type'] . "'>Done</button></td>";
                                    } else {
                                        echo "<td><button class='btn btn-secondary' disabled>Done</button></td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No feedbacks found</td></tr>";
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

        <script>
            //search
            $('#searchBtn').on('click', function() {
    var status = $('#status').val();
    var type = $('#type').val();

    $.ajax({
        url: 'fetch_feedback.php',
        method: 'GET',
        data: {
            status: status,
            type: type
        },
        success: function(response) {
            $('#data').html(response);
        }
    });
});
        // Handle the 'Done' button click
                                    $(document).on('click', '#btnDone', function () {
                                        var feedbackId = $(this).data('fid');
                                        var userId = $(this).data('uid');
                                        var type=$(this).data('type');
                                        
                                        $.ajax({
                                            url: 'update_feedback_status.php',
                                            method: 'POST',
                                            data: {fid: feedbackId, uid: userId, type: type},
                                            success: function (response) {

                                                alert('Feedback status updated and email sent.');
                                                location.reload(); // Reload the page to reflect the change

                                            }
                                        });
                                    });
        </script>
    </body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
