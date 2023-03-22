<?php
    // set of variables which will hold data from POST request
    $nameFirst = "";
    $nameMiddle = "";
    $nameLast = "";
    $salutation = "";
    $age = "";
    $email = "";
    $phone = "";
    $dateArrive = "";
    $comment = "";
    $min_timestamp = strtotime('2023-01-01'); // to check time validity
    $max_timestamp = strtotime('2033-01-01');


    $salutationOptions = ["mr", "mrs", "ms","sir","doctor", "other", ""]; // if user's salute is not in the given list -> error message
    $issuesList = []; // a list where all the errors messages will be stored


    // function that will remove all unnecessary spaces,  slashes and to convert it into HTML chars
    function removeChars($value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }
     function isValidDate($date){
        $date_arr = explode('-', $date);
        if (count($date_arr) != 3){
            return false;
        }
        $year = (int)$date_arr[2];
        $month = (int)$date_arr[1];
        $day = (int)$date_arr[0];

        if (!checkdate($month, $day, $year)){
            return false;
        }

        return true;
    }

    

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){ // code is executed when button submit is pressed
         // validity check of first name
        if (empty($_POST["nameFirst"])){
            $issuesList[] = "First name is mandatory to submit!";
        } else{
            $nameFirst = removeChars($_POST["nameFirst"]);
            if (!preg_match("/^[a-zA-Z-' ]+$/", $nameFirst)){
                $issuesList = "Only alphabet chars are allowed to be in the first name";
            }
        }

        // validity check of middle name
        if (empty($_POST["nameMiddle"])){
            $nameMiddle = ""; // since this field is not required we may keep it empty as it is
        } else{
            $nameMiddle = removeChars($_POST["nameMiddle"]);
            if (!preg_match("/^[a-zA-Z-' ]+$/", $nameMiddle)){
                $issuesList[] = "Only alphabet chars are allowed to be in the middle name";
            }
        }

        // validity check of last name
        if (empty($_POST["nameLast"])){
            $issuesList[] = "Last name is mandatory to submit!";
        } else{
            $nameLast = removeChars($_POST["nameLast"]);
            if (!preg_match("/^[a-zA-Z-' ]+$/", $nameLast)){
                $issuesList[] = "Only alphabet chars are allowed to be in the last name";
            }
        }

        // validity check salutation
        if (empty($_POST["salute"])){
            $salutation = ""; // not required -> keep it empty
        } else{
            $salutation = removeChars($_POST["salute"]);
            if (!preg_match("/^[a-zA-z]*$/", $salutation) || !in_array($salutation, $salutationOptions)){
                $issuesList[] = "Your salutation is not in the given list";
            }
        }
        // validity check of age
        if (empty($_POST["age"])){
            $issuesList[] = "Your age is mandatory to submit";
        } else{
            $age = removeChars($_POST["age"]);
            if ($age > 99 || $age < 18){
                $issuesList[] = "Your age is not in the predefined range";
            }
        }

        // validity check of an email
        if (empty($_POST["email"])){
            $issuesList[] = "Email is mandatory to submit";
        } else{
            $email = removeChars($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $issuesList[] = "Your email is written in invalid format";
            }
        }

        // validity check of phone number
        if (empty($_POST["phone"])){
            $phone = "";
        } else{
            $phone = removeChars($_POST["phone"]);
            if (!preg_match("/^\+?\d{9,10}$/", $phone)){
                $issuesList[] = "Your phone number is written in invalid format";
            }
        }
        
        // validity check of arrival date
        if (empty($_POST["dateArrive"])) {
            $issuesList[] = "Date of arrival is required to be inputted";
        } else {
            $dateArrive = removeChars($_POST["dateArrive"]);
            $pattern = "/^\d{4}-\d{2}-\d{2}$/"; //regex pattern for yyyy-mm-dd format
            if (!preg_match($pattern, $dateArrive)) {
                $issuesList[] = "Date of arrival must be in the format of yyyy-mm-dd";
            } else {
                $timeStamp = strtotime($dateArrive);
                if ($timeStamp < $min_timestamp || $timeStamp > $max_timestamp || !isValidDate($timeStamp)) {
                    $issuesList[] = "Submitted date is not in the given range";
                }
            }
        }
        

        if(empty($_POST["comment"])){
            $comment = "";
        } else{
            $comment = $_POST["comment"];
        }

        $fileName = 'data.csv';
        $file = fopen($fileName, 'a+');

        $dataCsv = [$nameFirst, $nameMiddle, $nameLast, $salutation, $age, $email, $phone, $dateArrive, $comment];
        $confirmText = "$nameFirst;$nameMiddle;$nameLast;$salutation;$age;$email;$phone;$dateArrive;$comment"; // recently-provided user data to include into .csv file
        if (empty($issuesList)){
            fputcsv($file, $dataCsv, ';');
        }
        fclose($file);

        if (isset($_POST["secretSubmit"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
            header('Content-Description: File Transfer');
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename=recentSubmit.csv');
            $lastInput = $_POST['secret'];
            $fileOpen = fopen('php://output', 'w');
            fwrite($fileOpen, $lastInput);
            fpassthru($fileOpen);
            fclose($fileOpen);
            exit();
        }

        }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Artem Fedorchenko">
    <link rel="stylesheet" href="./styles/style.css">
    <title>LAB 5 - PHP Form</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="./download.php">PHP INFO</a>
                </li>
                <li>
                    <a href="./index.php">PHP FORM</a>
                </li>
            </ul>
        </nav>
    </header>  
        <form action="index.php" method="post" id="formReserve">
            <!-- Separate lines for last first and middle names-->
            <label for="nameFirst">First Name:</label>
            <input type="text" name="nameFirst" id="nameFirst" pattern="[A-Za-z-' ]+" required placeholder="Enter your first name"><br>
            <label for="nameMiddle">Middle name:</label>
            <input type="text" name="nameMiddle" id="nameMiddle" pattern="[A-Za-z-' ]+" placeholder="Enter your middle name"><br>
            <label for="nameLast">Last name:</label>
            <input type="text" name="nameLast" id="nameLast" pattern="[A-Za-z-' ]+" required placeholder="Enter your last name"><br>
            <label for="salute">Salutation:</label>
            <select id="salute" name="salute">
                <option value="">--Please choose your salutation--</option>
                <option value="mr">Mr</option>
                <option value="ms">Ms</option>
                <option value="mrs">Mrs</option>
                <option value="sir">Sir</option>
                <option value="doctor">Dr</option>
                <option value="other">Other</option>
            </select><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="18" max="99" value="21" required><br>
            <label for="email">e-mail:</label>
            <input type="email" name="email" id="email" pattern="^[A-Za-z0-9-]+.?)+[^.]@[^-][A-Za-z]+-?[A-Za-z]+[^-].[A-Za-z]+$" required placeholder="Enter a valid email address"><br>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" pattern="\+?\d{9,10}" placeholder="Number as +000000000"><br>
            <label for="dateArrive">Date of arrival:</label>
            <input type="date" name="dateArrive" id="dateArrive" min="2023-01-01" max="2033-01-01" required><br>
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
            <label for="submitReservation"></label>
            <input type="submit" value="Submit" name="submitReservation" id="submitReservation">
        </form>  
        <div id="confirmedError">
            <?php
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                // when button submit is pressed and issuesList is not empty all the issues are displayed
                if (!empty($issuesList)){
                    foreach($issuesList as $issue)
                        echo "<p>$issue</p><br>";
                }
            }
            ?>
         </div>
        <div id="confirmedText">

        <?php
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        // if there were no issues then every successful entry is displayed and then it is suggested to download the last one 
    if (empty($issuesList)){
        $fileName = 'data.csv';
        $file = fopen($fileName, 'r');
        echo "<p>Successfully validated form</p><br>";
        echo $confirmText;
        
        // cited from lab feedback
        echo '<form method="post" action="index.php">
        <input type="hidden" name="secret" value='.$confirmText.'/>
        <input type="submit" name="secretSubmit" value="Download your data" />
        </form>';
        fclose($file);
    }
       
    }
    ?>

        </div>
</body>
</html>
