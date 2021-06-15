<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 4/29/2021
 * Time: 11:20 AM
 */

require_once "includes/header.php";
$showform = 1;
$errormsg = 0;
$erruname = "";
$errpwd = "";

if(isset($_SESSION['ID'])) {
    $showform = 0;
    echo"<br><br><br><br>";
    echo "<div class=userinfoblock><h1>User Information</h1>";
    try {
        $sql = "SELECT * FROM project_users WHERE users_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['ID']);
        $stmt->execute();
        $row = $stmt->fetch();
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
    $fname = $row['users_fname'];
    $lname = $row['users_lname'];
    $uname = $row['users_uname'];

    $state = $row['users_state'];
    $joined = $row['users_joined'];
    $email = $row['users_email'];
    $mailinglist = $row['users_mailinglist'];
    $status = $row['users_status'];

    echo "<p>Name: $fname $lname</p>";
    echo "<p>Username: $uname</p>";
    echo "<p>Email: $email</p>";
    echo "<p>State: $state";
    echo "<p>Account Created: $joined</p>";
    echo "</div>";
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $uname = trim(strtolower($_POST['uname']));
    $pwd = $_POST['pwd'];

    if (empty($uname)) {
        $erruname = "You must enter a username.";
        $errormsg = 1;
    }
    if (empty($pwd)) {
        $errpwd = "You must enter a password.";
        $errormsg = 1;
    }

    if($errormsg == 1) {
        echo "<p class='error'>There are errors. Please make corrections and resubmit.</p>";
    }
    else {
        try {
            $sql = "SELECT * FROM project_users WHERE users_uname = :uname";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':uname', $uname);
            $stmt->execute();
            $row = $stmt->fetch();
            if (password_verify($pwd, $row['users_pwd'])) {
                echo "<p class='success'>Login successful!</p>";
                $_SESSION['ID'] = $row['users_id'];
                $_SESSION['uname'] = $row['users_uname'];
                $_SESSION['status'] = $row['users_status'];

                header("Location: confirm.php?state=2");
            }
            else {
                echo "<p class='error'>The username and password you entered is not correct. Please try again.</p>";
            }
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
if($showform == 1) {
    ?>

        <br><br><br><br>
        <div class="logincontainer">
            <div class="loginblock">
            <form name="login" id="login" method="POST" action="login.php">
                <table>
                    <tr><th><label for="uname">Username:</label><span class="error">*</span></th>
                        <td><input name="uname" required id="uname" type="text" placeholder="Username"
                                   value="<?php if(isset($uname)) {
                                       echo $uname;
                                   }?>" /><span class="error"><?php if(isset($erruname)){echo $erruname;}?></span></td>
                    </tr>
                    <tr><th><label for="pwd">Password:</label><span class="error">*</span></th>
                        <td><input name="pwd" required id="pwd" type="password" placeholder="Required Password"/>
                            <span class="error"><?php if(isset($errpwd)){echo $errpwd;}?></span></td>
                    </tr>
                </table>
                <div class="centeritems"
                    <label for="submit"></label>
                    <input type="submit" name="submit" id="submit" value="submit"/>
                </div>
            </form>
            </div>
            <p>New to the site? <a href="register.php">Click here</a> to become a member today!</p>
        </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
}
require_once "includes/footer.php";
