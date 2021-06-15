<?php
/**
 * Class: csci303
 * User: Blake
 * Date: 5/3/2021
 * Time: 11:06 AM
 */


require_once "includes/header.php";


$showform = 1; //flag to show form - initially, show form.
$errmsg = 0; //flag to track errors - initially, no errors.
$errname = ""; //individual error message for first name
$errcity= ""; //individual error message for user name
$errstate = ""; //individual error message for email

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

    $name = $_POST['name'];
    $city = $_POST['city'];
    $state = $_POST['state'];


    if (empty($name)) {
        $errfname = "<span class='error'>First name is required</span><br>";
        $errmsg = 1;
    }
    if (empty($city)) {
        $errlname = "<br><br><span class='error'>City is required</span><br>";
        $errmsg = 1;
    }


    $sql = "SELECT * FROM project_airports WHERE airport_name = ?";
    $count = checkDup($pdo, $sql, $name);
    if($count > 0) {
        $errname = "<br><br><span class='error'>This airport is already created!</span><br>";
        $errmsg = 1;
    }


    if (empty($state)) {
        $state = "<br><br><span class='error'>State is required</span><br>";
        $errmsg = 1;
    }

    if ($errmsg == 1) {
        echo "<p class='error'>There are errors.  Please make changes and resubmit.</p>";
    } else {
        $showform = 0;

        $sql = "INSERT INTO project_airports (airport_name, airport_city, airport_state) 
                VALUES (:name, :city, :state) ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':state', $state);
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
        ?>
        <br>
        <div class="registerblock">
            <h2>Add Airport</h2>
            <form name="addairport" id="addairport" method="post" action = "<?php echo $currentFile;?>">
                <fieldset><legend>Airport</legend>
                    <?php
                    //display the error message (if any) above the form field.
                    if (isset($errfname)) {
                        echo $errfname;
                    }
                    ?>

                    <label for="name">Airport Name</label>
                    <input type="text" name="name" id="name" size="50"
                           maxlength="40" placeholder="Airport Name"
                           value="<?php if (isset($name)) { echo $name; }?>">

                    <?php
                    //display the error message (if any) above the form field.
                    if (isset($errlname)) {
                        echo $errlname;
                    }
                    ?>

                    <label for="city">City</label>
                    <input type="text" name="city" id="city" size="50"
                           maxlength="40" placeholder="City"
                           value="<?php if (isset($city)) { echo $city; }?>">


                    <?php
                    if (isset($errstate)) {
                        echo $errstate;
                    }
                    ?>
                    <br><br>
                    <div class="centeritems">
                    <label for="state">State</label>
                    <br><br>
                    <select name="state" id="state">

                        <?php foreach ($states as $key => $value) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>

                    </select>
                    <br>


                    <br><br>
                    <br><input type="submit" name="submit" id="submit" value="Submit Form"/>
                    </div>
                    <br>

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