<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/2/2021
 * Time: 2:17 PM
 */

require_once "includes/header.php";

$airport = $_GET['q'];
$airportsql = "SELECT airport_name FROM project_airports INNER JOIN project_reviews WHERE project_airports.airport_id = :airport";
$airportstmt = $pdo->prepare($airportsql);
$airportstmt->bindValue(':airport', $airport);
$airportstmt->execute();
$airportrow = $airportstmt->fetch();

$airportName = $airportrow['airport_name'];


//query the data
$sql = "SELECT * FROM project_reviews INNER JOIN project_users ON project_reviews.fk_users = project_users.users_id WHERE fk_airports = :airport";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':airport', $airport);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
    <div class="airportnameContainer">
    <h2 class="airportname">Reviews for <?php echo $airportName;?></h2>
    </div>
    <table class = airportdetails>
        <tr><th>Title</th><th>Review</th><th>Rating</th><th>User</th><th>Date</th></tr>
        <?php
        foreach ($result as $row) {
            ?>
            <tr><td><p><?php echo $row['reviews_title'];?></p></td>
                <td><?php echo $row['reviews_details'];?></td>
                <td><p><?php echo $row['reviews_rank'];?></p></td>
                <td><p><?php echo $row['users_uname'];?></p></td>
                <td><p><?php echo $row['reviews_date'];?></p></td>
            </tr>
            <?php echo "\n";
        }
        ?>
    </table><br><br>

<?php
require_once "includes/footer.php";
?>