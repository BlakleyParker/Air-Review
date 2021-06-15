<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 4/28/2021
 * Time: 9:50 AM
 */


require_once "includes/header.php";


$showform = 1; //flag to show form - initially, show form.
$errmsg = 0; //flag to track errors - initially, no errors.
$errfname = ""; //individual error message for first name
$erruname = ""; //individual error message for user name
$erremail = ""; //individual error message for email
$errpwd = ""; //individual error message for password
$errpwd2 = ""; //individual error message for confirmation password

$errmailinglist = "";
$errstate= "";

$states = array(
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
);


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $uname = strtolower(trim($_POST['uname']));
    $email = trim($_POST['email']);
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];
    $mailinglist = $_POST['mailinglist'];
    $state = $_POST['state'];


    if (empty($fname)) {
        $errfname = "<span class='error'>First name is required</span><br>";
        $errmsg = 1;
    }
    if (empty($lname)) {
        $errlname = "<br><br><span class='error'>Last name is required</span><br>";
        $errmsg = 1;
    }
    if (empty($uname)) {
        $erruname = "<br><br><span class='error'>Username is required</span><br>";
        $errmsg = 1;

    }
    if (empty($email)) {
        $erremail = "<br><br><span class='error'>Email is required</span><br>";
        $errmsg = 1;
    }

    $sql = "SELECT * FROM project_users WHERE users_uname = ?";
    $count = checkDup($pdo, $sql, $uname);
    if($count > 0) {
        $errmsg = 1;
        $erruname = "<br><br><span class='error'>This username is already taken!</span><br>";
    }

    $sql = "SELECT * FROM project_users WHERE users_email = ?";
    $count = checkDup($pdo, $sql, $uname);
    if($count > 0) {
        $errmsg = 1;
        $erremail = "<br><br><span class='error'>This email is already taken!</span><br>";
    }

    if (empty($pwd)) {
        $errpwd = "<br><br><span class='error'>Password is required</span><br>";
        $errmsg = 1;
    }
    if (empty($pwd2)) {
        $errpwd2 = "<br><br><span class='error'>Confirm password is required</span><br>";
        $errmsg = 1;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erremail = "<br><br><span class='error'>Invalid email address</span><br>";
        $errmsg = 1;
    }
    if (strlen($pwd) < 8 || strlen($pwd2) > 72) {
        $errpwd = "<br><br><span class='error'>Password does not meet the character requirement.</span><br>";

    }
    if ($pwd != $pwd2){
        $errpwd = "<br><br><span class='error'>Passwords do not match</span><br>";
        $errmsg = 1;
    }

    if (empty($mailinglist)) {
        $mailinglist = "<br><br><span class='error'>Mailing list choice is required</span><br>";
        $errmsg = 1;
    }
    if (empty($state)) {
        $state = "<br><br><span class='error'>State is required</span><br>";
        $errmsg = 1;
    }

    if ($errmsg == 1) {
        echo "<p class='error'>There are errors.  Please make changes and resubmit.</p>";
    } else {
        $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT);
        $showform = 0;

        $sql = "INSERT INTO project_users (users_fname, users_lname, users_uname, users_email, users_pwd, users_mailinglist, users_state) 
                VALUES (:fname, :lname, :uname, :email, :pwd, :mailinglist, :state) ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':lname', $lname);
        $stmt->bindValue(':uname', $uname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':pwd', $hashedpwd); //notice the hashed password
        $stmt->bindValue(':mailinglist', $mailinglist);
        $stmt->bindValue(':state', $state);
        $stmt->execute();
        echo "<p class='success'>Form submitted, Thank you!</p>";

        //EMAIL the user upon registration success
        $subject = "Welcome to Air Review!";
        $txt = "This is a message to let you know that you are registered and in the system. Be sure to leave a review! Thank you for joining and I hope you find everything satisfactory!  - Blakley Parker";
        mail($email,$subject,$txt);

        $showform = 0;
    } // else control code
}//submit


?>
    <main>
        <?php
        //Display the form
        if($showform == 1){
        ?>
        <br>
        <div class="registerblock">
        <h2>Registration Form</h2>
            <p>Please complete the form.  All fields are required unless otherwise instructed.</p>

            <form name="register" id="register" method="post" action = "<?php echo $currentFile;?>">
                <fieldset><legend>User Information</legend>
                    <?php
                    //display the error message (if any) above the form field.
                    if (isset($errfname)) {
                        echo $errfname;
                    }
                    ?>

                    <label for="fname">First Name</label>
                    <input type="text" name="fname" id="fname" size="50"
                           maxlength="40" placeholder="First Name"
                           value="<?php if (isset($fname)) { echo $fname; }?>">

                    <?php
                    //display the error message (if any) above the form field.
                    if (isset($errlname)) {
                        echo $errlname;
                    }
                    ?>

                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" id="lname" size="50"
                           maxlength="40" placeholder="Last Name"
                           value="<?php if (isset($lname)) { echo $lname; }?>">

                    <?php
                    if (isset($erruname)) {
                        echo $erruname;
                    }
                    ?>

                    <label for="uname">Username</label>
                    <input type="text" id="uname" name="uname" placeholder="Username" size="20" maxlength="50"
                           value="<?php if (isset($uname)) {echo $uname; }?>">

                    <?php
                    if (isset($erremail)) {
                        echo $erremail;
                    }
                    ?>

                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Email" size="100" maxlength="255"
                           value="<?php if (isset($uname)) {echo $uname; }?>">

                    <?php
                    if (isset($errpwd)) {
                        echo $errpwd;
                    }
                    ?>

                    <label for="pwd">Password</label>
                    <input type="password" id="pwd" name="pwd" placeholder="Password" size="100" minlength="8" maxlength="72"
                           value="<?php if (isset($pwd)) {echo $pwd; }?>">

                    <?php
                    if (isset($errpwd2)) {
                        echo $errpwd2;
                    }
                    ?>

                    <label for="pwd2">Confirm Password</label>
                    <input type="password" id="pwd2" name="pwd2" placeholder="Confirm Password" size="100" maxlength="72">
                    <br><br>
                    <?php
                    if (isset($errmailinglist)) {
                        echo $errmailinglist;
                    }
                    ?>
                    <div class="centeritems">
                    <label for="mailinglist">Join our mailing list?</label>
                    <br><br>
                    <input type="radio" id="1" name="mailinglist" value="YES" CHECKED>
                    <label for="1">Yes</label>
                    <input type="radio" id="2" name="mailinglist" value="NO">
                    <label for="2">No</label>
                    <br><br>
                    <?php
                    if (isset($errstate)) {
                        echo $errstate;
                    }
                    ?>
                    <br>

                    <label for="state">What state do you live in?</label>
                    <br><br>
                        <select name="state" id="state">

                                <?php foreach ($states as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>

                        </select>
                    <br>


                    <br><br>
                    <br><input type="submit" name="submit" id="submit" value="Submit Form"/>

                    <br>
                    </div>
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