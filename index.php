<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Artem Fedorchenko">
    <title>Document</title>
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
        <form action="form.validation.html" method="post" id="data">
            <label for="name">Name:</label>
            <input type="text" id="name" required placeholder="Enter your first, last and middle(optional) names"><br>
            <label for="salutation">Salutation:</label>
            <select id="salutation">
                <option value="">--Please choose your salutation--</option>
                <option value="mr">Mr</option>
                <option value="ms">Ms</option>
                <option value="mrs">Mrs</option>
                <option value="sir">Sir</option>
                <option value="doctor">Doctor</option>
                <option value="other">Other</option>
            </select>
        </form>
    </main>
</body>
</html>