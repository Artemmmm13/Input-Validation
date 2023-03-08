<?php
    if (isset($_POST["REQUEST_METHOD"] && $_SERVER['REQUEST_METHOD'] == 'POST')){
        header('Content-type: text/csv');
        header('Content-Disposition: attachment, filename="data.csv"');
        readfile('data.csv');
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
    <?php
    $file = file_get_contents($fileName);
    $counter = substr_count($file, '\n');
    return $counter;
    ?>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="/download.php">Download</a>
                </li>
                <li>
                    <a href="/index.php">Form</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="reservedText">Number registrations: <?php $counter?></div>
        <form action="download.php" method="post">
            <button type="submit" name="download">Download registration data:</button>
        </form>
    </main>
</body>
</html>
