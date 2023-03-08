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
                    <a href="/download.php">Download</a>
                </li>
                <li>
                    <a href="/index.php">Form</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div id="reservedText">Number registrations: 1</div>
        <form action="download.php" method="post">
            <button type="submit">Download registration data:</button>
        </form>
    </main>
</body>
</html>