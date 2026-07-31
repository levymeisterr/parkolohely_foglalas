<?php
    session_start();

    require_once "database.php";
    $pdo = connect();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $numplate = $_POST["number_plate"];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO felhasznalo (email, pw, rendszam) VALUES (:email, :pw, :rendszam)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":email" => $email,
            ":pw" => $hashedPassword,
            ":rendszam" => $numplate
        ]);

        header("Location: login.php");
        exit();

    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="registration.php" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="password">Number plate:</label>
        <input type="text" id="number_plate" name="number_plate" required maxlength="7" minlength="7" placeholder="XYZ-123">
        <br><br>
        <button type="submit">Sign Up</button>
    </form>
</body>
</html>