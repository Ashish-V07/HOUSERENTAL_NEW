<?php
$host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'test';

        $conn = mysqli_connect($host, $user, $pass, $db);
        
$id = $_GET['sid'];

    if($id ===""){
       $q="select * from tbl_users";
    }else{
        $q="SELECT * FROM tbl_users where fname like '$id%' or email like '$id%' or lname like '$id%' or mobile like '$id%'";
    }
     $result = mysqli_query($conn,$q);
    
        

?>

<h2>Jewelry Records</h2>
                <table>
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
            
    <?php ?>