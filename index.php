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

    $salutationOptions = ["mr.", "mrs.", "mrs.","sir","doctor", "other"]; // if user's salute is not in the given list -> error message
    $issuesList = []; // a list where all the errors messages will be stored


    // function that will remove all unnecessary spaces,  slashes and to convert it into HTML chars
    function removeChars($value){
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST["nameFirst"])){
            $issuesList = "First name is mandatory to submit!";
        } else{
            $nameFirst = removeChars($_POST["nameFirst"]);
            if (!preg_match("/^[a-zA-z]*$/", $nameFirst)){
                $issuesList = "Only alphabet chars are allowed to be in the first name";
            }
        }
    }

    if (empty($_POST["nameMiddle"])){
        $nameMiddle = ""; // since this field is not required we may keep it empty as it is
    } else{
        $nameMiddle = removeChars($_POST["nameMiddle"]);
        if (!preg_match("/^[a-zA-z]*$/", $nameMiddle)){
            $issuesList = "Only alphabet chars are allowed to be in the middle name";
        }
    }

    



    ?>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="./download.php">Download</a>
                </li>
                <li>
                    <a href="./index.php">Form</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="index.php" method="post" id="formReserve">
            <!-- Separate lines for last first and middle names-->
            <label for="fname">First Name:</label>
            <input type="text" name="nameFirst" id="nameFirst" required placeholder="Enter your first name"><br>
            <label for="lname">Last name:</label>
            <input type="text" name="nameLast" id="nameLast" required placeholder="Enter your last name"><br>
            <label for="mname">Middle name(optional)</label>
            <input type="text" name="nameMiddle" id="nameMiddle" placeholder="Enter your middle name"><br>
            <label for="salutation">Salutation:</label>
            <select id="salute" name="salute">
                <option value="">--Please choose your salutation--</option><br>
                <option value="mr">Mr</option>
                <option value="ms">Ms</option>
                <option value="mrs">Mrs</option>
                <option value="sir">Sir</option>
                <option value="doctor">Dr</option>
                <option value="other">Other</option>
            </select><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" size="7" min="18" max="99" value="21" required><br>
            <label for="email">e-mail:</label>
            <input type="email" name="email" id="email" required placeholder="Enter a valid email address"><br>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0,9]{3}-[0-9]{3}" placeholder="Number as 000-000-000"><br>
            <label for="arrival">Date of arrival:</label>
            <input type="date" name="dateArrive" id="dateArrive" min="2023-01-01" max="2033-01-01" required><br>
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
            <label for="submit"></label>
            <input type="submit" value="Submit" name="submitReservation" id="submitReservation"required>
        </form>    
        <div id="confirmedError">
            <?php
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                if (!empty($issues)){
                    echo "<p>Successfully validated forms</p><br>";
                    foreach($issues as $issue)
                        echo "<p>$issue</p><br>";
                }
            }
            ?>
         </div>
        <div id="confirmedText">

            <?php
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
                $fileName = 'data.csv';
                $file = fopen($fileName, 'r');
                while (($line = fgetcsv($file, 0, ';')) !== false){
                    foreach($line as $input){
                        echo $input . " ";
                    }
                    echo '<br>';
                }
                fclose($file);
            }
            ?>
        </div>
    </main>
</body>
</html>