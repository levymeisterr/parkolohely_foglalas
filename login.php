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
        $error = "Hibás email vagy jelszó!";
    }
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
</head>
<body>

<h1>Bejelentkezés</h1>

<?php if (isset($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" action="login.php">

    <label for="email">Email:</label>
    <input
        type="email"
        id="email"
        name="email"
        required
    >

    <br><br>

    <label for="password">Jelszó:</label>
    <input
        type="password"
        id="password"
        name="password"
        required
    >

    <br><br>

    <button type="submit">Bejelentkezés</button>

</form>

</body>
</html>
