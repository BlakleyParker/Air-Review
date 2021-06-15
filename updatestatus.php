<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/7/2021
 * Time: 9:51 AM
 */

require_once "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])){
    $user_no = $_GET['q'];
}
elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ID'])){
    $user_no = $_POST['ID'];
}
else {
    echo "<p class='error'>Something happened! Cannon obtain correct entry. </p>";
    $errmsg = 1;
}


$showform = 1; //flag to show form - initially, show form.
$errmsg = 0; //flag to track errors - initially, no errors.
$errdept = ""; //individual error message for user name


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $status = $_POST['statusupdate'];




    if ($errmsg == 1) {
        echo "<p class='error'>There are errors.  Please make changes and resubmit.</p>";
    } else {
        echo "<p class='success'>User status updated!</p>";
        $showform = 0;

        $sql = "UPDATE project_users SET users_status = :status
                WHERE users_id = :id ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $user_no);
        $stmt->execute();
        echo "<p class='success'>Form submitted, Thank you!</p>";
        $showform = 0;
    } // else control code
}//submit


?>
<main>
    <?php
    //Display the form
    if($showform == 1){

        //query the data
        $sql = "SELECT * FROM project_users WHERE users_id = :id";
        //prepares a statement for execution
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $user_no);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        ?>
        <br><br>
        <div class="registerblock">
        <h2>Update User Status</h2>
        <div class="centeritems">


        <form name="status" id="status" method="post" action = "<?php echo $currentFile;?>">
            <fieldset>
                <p>
                <?php
                echo $result['users_fname'] . ", " . $result['users_lname']
                ?></p>

                <label for="statusupdate">Please choose a status:</label>
                <br><br>
                <input type="radio" id="1" name="statusupdate" value="0" CHECKED>
                <label for="1">User</label>
                <input type="radio" id="2" name="statusupdate" value="1">
                <label for="2">Admin</label>
                <br><br>

                <input type="hidden" name="ID" value="<?php echo $result['users_id'];?>">
                <input type="submit" name="thesubmit" id="submit" value="Update"/>



            </fieldset>
        </form>
        </div>
        </div>
        <?php
    }//showform
    ?>

    </div>
</main>
<br><br><br>
<?php

require_once "includes/footer.php";
?>