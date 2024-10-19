<?php
        // Database connection
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'test';

        $conn = mysqli_connect($host, $user, $pass, $db);
        $q="select * from tbl_users";
        $result = mysqli_query($conn,$q);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Display ID</title>
        <script>
            function getdata(id){
                var a = new XMLHttpRequest(); 
                
                a.onreadystatechange = function (){
                    if(this.readyState === 4 && this.status === 200){ 
                        document.getElementById("sdata").innerHTML = this.responseText;
                    }
                };
                a.open("GET", "dis.php?sid=" + id, true);                
                a.send();
            }
        </script>
        <style>
            table,th,tr,td{
                border: solid black 1px;
            }
        </style>
    </head>
    
    <body>
         <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.html">
            <img src="images/logo.png" alt="" />
          </a>
          <div class="navbar-collapse" id="">
            <ul class="navbar-nav justify-content-between ">
              <div class="User_option">
                <li class="">
                  <a class="mr-4" href="logout.php">
                    Logout
                  </a>
                </li>
              </div>
            </ul>
            <div class="custom_menu-btn">
              <button onclick="openNav()">
                <span class="s-1"></span>
                <span class="s-2"></span>
                <span class="s-3"></span>
              </button>
            </div>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="dashboard.php">HOME</a>
                <a href="about.php">ABOUT</a>
                <a href="house.php">HOUSE</a>
                <a href="rent.php">PRICING</a>
                <a href="contactus.php">CONTACT US</a>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>
        <form>
            <h2>Enter id:</h2>
            <input type="text" id="txtid" onkeyup="getdata(this.value)">
            <div id="sdata">
             <h2>Jewelry Records</h2>
                  <table >
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Mobile NO.</th>
                        <th>Date Of Birth</th>
                        <th>Aadhar No.</th>
                        <th>Address</th>
                    </tr>
                   <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo "<b>", $row['id'], "</b>"; ?></td>
                            <td><?php echo "<b>", $row['fname'], "</b>"; ?></td>
                            <td><?php echo "<b>", $row['lname'], "</b>"; ?></td>
                            <td><?php echo "<b>", $row['mobile'], "</b>"; ?></td>
                            <td><?php echo "<b>", $row['dob'], "</b>"; ?></td>
                            <td><?php echo "<b>", $row['aadhar'], "</b>"; ?></td>
                            <td><?php echo "<b>", $row['address'], "</b>"; ?></td>
                            
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </form>
    </body>
</html>

