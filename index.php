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
            <!-- Separate lines for last first and middle names-->
            <label for="name">Name:</label>
            <input type="text" id="name" required placeholder="Enter your first, last and middle(optional) names"><br>
            <label for="salutation">Salutation:</label>
            <select id="salutation">
                <option value="">--Please choose your salutation--</option><br>
                <option value="mr">Mr</option>
                <option value="ms">Ms</option>
                <option value="mrs">Mrs</option>
                <option value="sir">Sir</option>
                <option value="doctor">Doctor</option>
                <option value="other">Other</option>
            </select><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" size="7" min="18" max="99" value="21" required><br>
            <label for="email">e-mail:</label>
            <input type="email" name="email" id="email" required placeholder="Enter a valid email address"><br>
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" pattern="[0-9,+]{1,6} [0,9]{3} [0-9]{3}"required placeholder="Number as 000 000 000" readonly><br>
            <label for="arrival">Date of arrival:</label>
            <input type="date" name="arrival" id="arrival" min="2023-01-01" max="2033-01-01" required><br>
        </form>
    </main>
</body>
</html>