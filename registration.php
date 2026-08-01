<?php
    session_start();

    require_once "database.php";
    $pdo = connect();

    function isValidNumberPlate($numplate)
    {
        $numplate = strtoupper($numplate);

        return preg_match('/^[A-Z]{3}-[0-9]{3}$/', $numplate) === 1;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $numplate = $_POST["number_plate"];
        $numplate = strtoupper($numplate);
        if (!isValidNumberPlate($numplate)) {
            $error = "Wrong number plate format!";
        }else{
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $sql = "INSERT INTO felhasznalo (email, pw, rendszam) VALUES (:email, :pw, :rendszam)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                        ":email" => $email,
                        ":pw" => $hashedPassword,
                        ":rendszam" => $numplate
                ]);
                header("Location: login.php");
                exit();
            }catch (PDOException $e){
                if ($e->getCode() == 23000) {
                    if (str_contains($e->getMessage(), "email")) {
                        $error = "Email already exists!";
                    }else if (str_contains($e->getMessage(), "rendszam")) {
                        $error = "Number plate already exists!";
                    }
                }
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/style.css" type="text/css">
    <title>Registration</title>
</head>
<body>
<h1>Registration</h1>
    <form action="registration.php" method="POST" class="form-container">
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
    <p>Already signed up? <a href="login.php">Log In!</a> </p>
    <?php if (isset($error)): ?>
        <p style="color: red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</body>
</html>