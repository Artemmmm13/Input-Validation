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
        <?php
    // receiving data from user
    $fname = $_POST['nameFirst'];
    $lname = $_POST['nameLast'];
    $mname = $_POST['nameMiddle'];
    $salutation = $_POST['salute'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['dateArrive'];
    $comment = $_POST['comment'];
    $submit = $_POST['submitReservation'];
    $startDate = new DateTime("2023-01-01");
    $endDate = new DateTime("2033-01-01");
    $userDate = new DateTime($date);

    // function to remove unnecessary spaces
    function removeSpaces($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        // validation of data
        $issues = [];
        if (empty($fname)){
            $issues[] = "First name is required";
        } else{
            $fname = removeSpaces($fname);
        } if (!preg_match("/^[a-zA-z]*$/", $fname)){
            $issues[] = "Your first name contains invalid symbols";
        }

    
        if (empty($lname)){
            $issues[] = "Last name is required";
        } else{
            $lname = removeSpaces($lname);
        } if (!preg_match("/^[a-zA-z]*$/", $lname)){
            $issues[] = "Your last name contains invalid symbols";
        }

        if (empty($mname)){
            $mname = "";
        } else{
            $mname = removeSpaces($mname);
        } if (!empty($mname)){
            if (!preg_match("/^[a-zA-z]*$/", $mname)){
                $issues[] = "Your middle name contains invalid symbols";
            }
        }


        if (empty($salutation)){
            $issues[] = "Salutation is required";
        }

        if (empty($age)){
            $issues[] = "Enter your age please";
        } else {
            $age = removeSpaces($age);
        }  if ($age > 99 || $age < 18){
            $issues[] = "Your age is in the invalid range";
        }

        if (empty($email)){
            $issues[] = "Email is required";
        } else{
            $email = removeSpaces($email);
        } if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $issues[] = "Email address contains invalid symbols";
        }

        if (empty($phone)){
            $issues[] = "Phone number is required";
        } else{
            $email = removeSpaces($email);
        }  if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/", $phone)){
            $issues[] = "Only numeric values in number are allowed";
        }

        if (empty($date)){
            $issues[] = "Arrival date is required";
        } else{
            $date = removeSpaces($date);
        } if ($userDate > $endDate || $userDate < $startDate){
            $issues[] = "Your date of arrival is not in the given range";
        }

        if (empty($comment)){
            $comment = "";
        } else{
            $comment = removeSpaces($comment);
        } 
        
    // writing into a file 
    $fileName = 'data.csv';
    $file = fopen($fileName, 'a+');
    $csvData = array($fname, $lname, $mname, $salutation, $age, $email, $phone, $date, $comment, ';'); 
    // if array with issues is empty i put user data into it
    if (empty($issues)){
        fputcsv($file, $csvData, ';');
    }

    fclose($file);
    }
?>

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