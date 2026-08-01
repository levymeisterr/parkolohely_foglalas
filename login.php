<?php

    session_start();

    require_once "database.php";

    $pdo = connect();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM felhasznalo WHERE email = :email";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":email" => $email
        ]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["pw"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];

            header("Location: index.php");
            exit();

        } else {
            $error = "Wrong Email or password!";
        }
    }

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h1>Login</h1>

<?php if (isset($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="login.php">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Login</button>
</form>
<p>No user yet? <a href="registration.php">Sign Up!</a></p>
</body>
</html>
