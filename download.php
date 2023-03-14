<?php
    if (isset($_POST["download"]) && $_SERVER['REQUEST_METHOD'] == 'POST'){
        header('Content-Description: File Transfer');
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=arrivals.csv');
        header('Expires: 0');
        header('Cache-Control: must-revalidate,  post-check=0, pre-check=0');
        header('Pragma: public');
        $fileCsv = fopen('php://output', 'w');
        $contents = file_get_contents('data.csv');
        fwrite($fileCsv, $contents);
        fclose($fileCsv);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Artem Fedorchenko">
    <title>LAB 5 - PHP Info</title>
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
    <main>
        <div id="reservedText">Number registrations:  <?php
   $fileName = 'data.csv';
   $fileArray = file($fileName, FILE_IGNORE_NEW_LINES);
   $counter = count($fileArray);
   echo $counter;
    ?></div>
        <form action="download.php" method="post">
            <button type="submit" name="download" id="download">Download registration data</button>
        </form>
    </main>
</body>
</html>
