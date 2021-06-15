<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/3/2021
 * Time: 8:37 AM
 */

require_once "includes/header.php";


//query the data
$sql = "SELECT * FROM project_users ORDER BY users_lname";
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
//executes a prepared statement
$stmt->execute();
//Returns an array containing all of the result set rows
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
    <main>
    <br><br>
    <table class="airportlist">
        <tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>State</th><th>Status</th><th>Update Status</th></tr>
        <?php
        foreach ($result as $row) {
            if ($row['users_status'] == 0) {
                $status = 'User';
            } else {
                $status = 'Admin';
                }

            ?>

            <tr><td><?php echo $row['users_fname'];?></td><?php echo "\n";?>
                <td><?php echo $row['users_lname'];?></td><?php echo "\n";?>
                <td><?php echo $row['users_uname'];?></td><?php echo "\n";?>
                <td><?php echo $row['users_email'];?></td><?php echo "\n";?>
                <td><?php echo $row['users_state'];?></td><?php echo "\n";?>
                <td><?php echo $status;?></td><?php echo "\n";?>
                <td><a href="updatestatus.php?q=<?php echo $row['users_id'];?>">Update</a></td><?php echo "\n";?>
            </tr>
            <?php echo "\n";
        }
        ?>
    </table>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    </main>
<?php
require_once "includes/footer.php";
?>