<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/3/2021
 * Time: 11:44 AM
 */

require_once "includes/header.php";
?>
    <main>

    <div class="registerblock">
        <h2>Search Airport</h2>
        <form name="searchairport" id="searchairport" method="POST" action = "<?php echo $currentFile;?>">
            <fieldset>

                <label for="airport_name">Search by Airport name: </label>
                <input type="text" name="airport_name" id="airport_name" size="50"
                       maxlength="40" value="" placeholder="Search by airport name:" />
                <br><br>
                <div class="centeritems">
                <br><input type="submit" name="submit" id="submit" value="Search"/>
                </div>
                <br>
            </fieldset>
        </form>
    </div>
    <table class="airportlist">
<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $search = trim($_POST['airport_name']) . "%";
    //SELECT * FROM project_airports WHERE airport_name LIKE :airname

    //query the data
    $sql = "SELECT * FROM project_airports WHERE airport_name LIKE :airport_name";
    //prepares a statement for execution
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':airport_name', $search);
    //executes a prepared statement
    $stmt->execute();
    //Returns an array containing all of the result set rows
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<br><br><br><br>";
    ?>  <tr><th>Airport</th><th>City</th><th>State</th><th>Options</th></tr>
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
}
    ?>
    </table><br><br><br><br>

<?php require_once "includes/footer.php";
?>