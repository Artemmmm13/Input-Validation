<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // receiving data from user
        $fname = $_POST['nameFirst'];
        $lname = $_POST['nameLast'];
        $mname = $_POST['nameMiddle'];
        $salutation = $_POST['saluteMr,saluteMs,saluteOther'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date = $_POST['dateArrive'];
        $comment = $_POST['comment'];
        $submit = $_POST['submitReservation'];
        $startDate = new DateTime("2023-01-01");
        $endDate = new DateTime("2033-01-01");
        $userDate = new DateTime($date);

        // validation of data
        $issues = [];
        if (empty($fname)){
            $issues[] = "First name is required";
        }
        if (!preg_match("/^[a-zA-z]*$/", $fname)){
            $issues[] = "Your first name contains invalid symbols";
        }
        if (empty($lname)){
            $issues[] = "Last name is required";
        }
        if (!preg_match("/^[a-zA-z]*$/", $lname)){
            $issues[] = "Your last name contains invalid symbols";
        }
        if (!preg_match("/^[a-zA-z]*$/", $mname)){
            $issues[] = "Your middle name contains invalid symbols";
        }
        if (empty($salutation)){
            $issues[] = "Salutation is required";
        }
        if (empty($age)){
            $issues[] = "Enter your age please";
        }
        if ($age > 99 || $age < 18){
            $issues[] = "Your age is in the invalid range";
        }
        if (empty($email)){
            $issues[] = "Email is required";
        }
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^/", $email)){
            $issues[] = "Email address contains invalid symbols";
        }
        if (empty($phone)){
            $issues[] = "Phone number is required";
        }
        if (!preg_match("/^[0-9]*$/", $phone)){
            $issues[] = "Only numeric values in number are allowed";
        }
        if (empty($date)){
            $issues[] = "Arrival date is required";
        }
        if ($userDate > $endDate || $userDate < $startDate){
            $issues[] = "Your date of arrival is not in the given range";
        }
        if (empty($agree)){
            $issues[] = "Please confirm that you have agreed to our terms and conditions";
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
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Form</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="data">
            <!-- Separate lines for last first and middle names-->
            <label for="fname">First Name:</label>
            <input type="text" name="nameFirst" id="nameFirst" required placeholder="Enter your first name"><br>
            <label for="lname">Last name:</label>
            <input type="text" name="nameLast" id="nameLast" required placeholder="Enter your last name"><br>
            <label for="mname">Middle name(optional)</label>
            <input type="text" name="nameMiddle" id="nameMMiddle" placeholder="Enter your middle name"><br>
            <label for="salutation">Salutation:</label>
            <select id="saluteMr,saluteMs,saluteOther" name="salute" required>
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
            <input type="tel" id="phone" name="phone" pattern="[0-9,+]{1,6} [0,9]{3} [0-9]{3}" placeholder="Number as 000 000 000"><br>
            <label for="arrival">Date of arrival:</label>
            <input type="date" name="dateArrive" id="dateArrive" min="2023-01-01" max="2033-01-01" required><br>
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
            <label for="submit"></label>
            <input type="submit" value="submit" name="submitReservation" id="submitReservation"required>
        </form>
        <?php
        if (!empty($issues)){
            foreach($issues as $issue){
                echo "<p>$issue</p>";
            }
        }
        else{
            $fileName = 'data.csv';
            $file = fopen($fileName, 'a+');
            $csvData = array($_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['salutation'], $_POST['age'], $_POST['email'], $_POST['phone'], $_POST['arrival'], $_POST['agree'], ';');
            fputcsv($file, $csvData);
            fclose($file);
        }
        ?>
    </main>
</body>
</html>