<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/3/2021
 * Time: 7:50 PM
 */
require_once "includes/header.php";



//query the data
$sql = "SELECT * FROM project_airports ORDER BY airport_name";
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
//executes a prepared statement
$stmt->execute();
//Returns an array containing all of the result set rows
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
    <br><br>
    <table class="airportlist">
        <tr><th>Airport</th><th>City</th><th>State</th><th>Options</th></tr>
        <?php
        foreach ($result as $row) {
            ?>
            <tr><td><?php echo $row['airport_name'];?></td><?php echo "\n";?>
                <td><?php echo $row['airport_city'];?></td><?php echo "\n";?>
                <td><?php echo $row['airport_state'];?></td><?php echo "\n";?>
                <td><a href="viewdetails.php?q=<?php echo $row['airport_id'];?>">View Details</a></td><?php echo "\n";?>
            </tr>
            <?php echo "\n";
        }
        ?>
    </table>
    <br><br><br><br><br><br><br><br><br><br><br><br>

<?php require_once "includes/footer.php";
?>