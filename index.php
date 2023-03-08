<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // receiving data from user
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $mname = $_POST['mname'];
        $salutation = $_POST['salutation'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $date = $_POST['arrival'];
        $agree = $_POST['agree'];
        $startDate = new DateTime("2023-01-01");
        $endDate = new DateTime("2033-01-01");
        $userDate = new DateTime($date);

        // validation of data
        $issues = [];
        if (!isset($fname)){
            $issues[] = "First name is required";
        }
        if (!preg_match("/^[a-zA-z]*$/", $fname)){
            $issues[] = "Your first name contains invalid symbols";
        }
        if (!isset($lname)){
            $issues[] = "Last name is required";
        }
        if (!preg_match("/^[a-zA-z]*$/", $lname)){
            $issues[] = "Your last name contains invalid symbols";
        }
        if (!preg_match("/^[a-zA-z]*$/", $mname)){
            $issues[] = "Your middle name contains invalid symbols";
        }
        if (!isset($salutation)){
            $issues[] = "Salutation is required";
        }
        if (!isset($age)){
            $issues[] = "Enter your age please";
        }
        if ($age > 99 || $age < 18){
            $issues[] = "Your age is in the invalid range";
        }
        if (!isset($email)){
            $issues[] = "Email is required";
        }
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^/", $email)){
            $issues[] = "Email address contains invalid symbols";
        }
        if (!isset($phone)){
            $issues[] = "Phone number is required";
        }
        if (!preg_match("/^[0-9]*$/", $phone)){
            $issues[] = "Only numeric values in number are allowed";
        }
        if (!isset($date)){
            $issues[] = "Arrival date is required";
        }
        if ($userDate > $endDate || $userDate < $startDate){
            $issues[] = "Your date of arrival is not in the given range";
        }
        if (!isset($agree)){
            $issues[] = "Please confirm that you have agreed to our terms and conditions";
        }

        if (empty($issues) && !empty($_POST)){
             // otherwise writing user data into csv file
           $fileName = 'data.csv';

           // checking if such a file exists
           if (!file_exists($fileName)){
            $file = fopen($fileName, 'w');
            fputcsv($file, array('First Name', 'Middle Name', 'Last Name', 'Salutation', 'Age', 'Email', 'Phone', 'Date'), ';');
            fclose($file);
           }

           // open existing file and writing user data into it
           try{
            $file = fopen($fileName, 'a');
            fputcsv($file, array($_POST['fname'], $_POST['mname'], $_POST['lname'], $_POST['salutation'], $_POST['age'], $_POST['email'], $_POST['phone'], $_POST['arrival']), ';');
            echo end(file($fileName));
            fclose($file);
           } catch (Exception $e){
            throw new Exception("File wasn't found!");
           }
        }
        else{
            foreach($issues as $issue){
                echo "<p>$issue</p>";
            }
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
            <input type="text" id="fname" required placeholder="Enter your first name"><br>
            <label for="lname">Last name:</label>
            <input type="text" name="lname" id="lname" required placeholder="Enter your last name"><br>
            <label for="mname">Middle name(optional)</label>
            <input type="text" name="mname" id="mname" placeholder="Enter your middle name"><br>
            <label for="salutation">Salutation:</label>
            <select id="salutation" required>
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
            <input type="date" name="arrival" id="arrival" min="2023-01-01" max="2033-01-01" required><br>
            <input type="checkbox" id="agree" name="agree">
            <label for="agree">I agree to terms and conditions</label><br>
            <input type="submit" value="submit" required>
        </form>
    </main>
</body>
</html>