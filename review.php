<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/1/2021
 * Time: 6:27 PM
 */


require_once "includes/header.php";

$currenttime = time();
$showform = 1; //flag to show form - initially, show form.
$errmsg = 0; //flag to track errors - initially, no errors.

$errtitle = ""; //individual error message for first name
$errrank = "";
$errdetails = "";

if(isset($_SESSION['ID'])) {
    $user =  $_SESSION['ID'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $rank = $_POST['rank'];
    $details = $_POST['details'];
    $airport = $_POST['airport'];

    if (empty($title)) {
        $errtitle = "<span class='error'>Title is required</span><br>";
        $errmsg = 1;
    }

    if (empty($rank)) {
        $errrank = "<br><br><span class='error'>Star rating is required</span><br>";
        $errmsg = 1;
    }

    if (empty($details)) {
        $errdetails = "<br><br><span class='error'>Review is required</span><br>";
        $errmsg = 1;
    }


    if ($errmsg == 1) {
        echo "<p class='error'>There are errors.  Please make changes and resubmit.</p>";
    } else {
        $showform = 0;

        $sql = "INSERT INTO project_reviews (reviews_title, reviews_details, reviews_rank, fk_users, fk_airports) 
                VALUES (:reviews_title, :reviews_details, :reviews_rank, :fk_users, :fk_airports) ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':reviews_title', $title);
        $stmt->bindValue(':reviews_details', $details);
        $stmt->bindValue(':reviews_rank', $rank);
        $stmt->bindValue(':fk_users', $user); //notice the hashed password
        $stmt->bindValue(':fk_airports', $airport);
        $stmt->execute();
        echo "<p class='success'>Review submitted, Thank you!</p>";
        $showform = 0;
    } // else control code
}//submit
else {
    $airport = $_GET['q'];
    $airportsql = "SELECT airport_name FROM project_airports INNER JOIN project_reviews WHERE project_airports.airport_id = :airport";
    $airportstmt = $pdo->prepare($airportsql);
    $airportstmt->bindValue(':airport', $airport);
    $airportstmt->execute();
    $airportrow = $airportstmt->fetch();

    $airportName = $airportrow['airport_name'];

}


?>
    <main>
        <?php
        //Display the form
        if($showform == 1){
        ?>
        <br>
        <div class="registerblock">
            <h2>Review Form</h2>
            <form name="review" id="review" method="post" action = "<?php echo $currentFile;?>">
                <fieldset><legend>User Review for <?php echo $airportName;?></legend>
                    <?php
                    //display the error message (if any) above the form field.
                    if (isset($errtitle)) {
                        echo $errtitle;
                    }
                    ?>

                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" size="50"
                           maxlength="40" placeholder="Title"
                           value="<?php if (isset($title)) { echo $title; }?>">
                    <br><br>

                    <?php
                    if (isset($errdetails)) {
                        echo $errdetails;
                    }
                    ?>
                    <br><br>
                    <label for="details">Leave a detailed review...</label>
                    <br>
                    <textarea id="details" name="details"></textarea>


                    <br><br>
                    <?php
                    if (isset($errrank)) {
                        echo $errrank;
                    }
                    ?>

                    <label for="rank">Rating</label>
                    <br><br>
                    <input type="radio" id="1" name="rank" value="1">
                    <label for="1">1 Star</label>
                    <input type="radio" id="2" name="rank" value="2">
                    <label for="2">2 Stars</label>
                    <input type="radio" id="3" name="rank" value="3" CHECKED>
                    <label for="3">3 Stars</label>
                    <input type="radio" id="4" name="rank" value="4">
                    <label for="4">4 Stars</label>
                    <input type="radio" id="5" name="rank" value="5">
                    <label for="5">5 Stars</label>
                    <br><br>
                    <input type="hidden" name="airport" value="<?php echo $airport;?>">
                    <br><input type="submit" name="submit" id="submit" value="Submit Form"/>



                </fieldset>
            </form>
            <?php
            }//showform
            ?>

        </div>
    </main>
    <br><br><br>
<?php

require_once "includes/footer.php";
?>