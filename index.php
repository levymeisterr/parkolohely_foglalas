<?php
    require_once "database.php";
    require_once "reservation.php";

    $pdo = connect();

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["createReservation"])) {

        $kezdetiDatum = $_POST["kezdeti_datum"];
        $vegDatum = $_POST["veg_datum"];

        createReservation(
            $pdo,
            $kezdetiDatum,
            $vegDatum
        );
    }
    elseif (isset($_POST["deleteReservation"])) {
        $id = $_POST["deleteReservation"];
        deleteReservation($pdo, $id);
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
    <title>Document</title>
</head>
<body>
<form method="POST">
    <label for="kezdeti_datum">Kezdet:</label>
    <input
            type="datetime-local"
            id="kezdeti_datum"
            name="kezdeti_datum"
            required
    >

    <label for="veg_datum">Vége:</label>
    <input
            type="datetime-local"
            id="veg_datum"
            name="veg_datum"
            required
    >
    <button type="submit" name="createReservation">Reserve a parking space!</button>
</form>

<h1>FOGLALÁSOK</h1>
<form method="POST">
    <button type="submit" name="showAllRes">Show all reservations</button>
</form>
<form method="POST">
    <button type="submit" name="showIdRes">Show my reservations</button>
</form>

<table>
    <tr>
        <td>Parking space</td>
        <td>Start date</td>
        <td>End date</td>
        <td>Number plate</td>
        <td></td>
    </tr>
    <?php
        if (isset($_POST['showAllRes'])) {
            $foglalasok = getAllReservations($pdo);
            foreach ($foglalasok as $foglalas) {
                echo "<tr>";
                echo "<td>" . $foglalas["parkolohely_szam"] . "</td>";
                echo "<td>" . $foglalas["kezdeti_datum"] . "</td>";
                echo "<td>" . $foglalas["veg_datum"] . "</td>";
                echo "<td>" . $foglalas["rendszam"] . "</td>";
                echo "<td><form method='POST'>";
                if ($foglalas["uid"] == $_SESSION["user_id"]) {
                    echo "<button type='submit' name='deleteReservation' value='" . $foglalas["id"] . "'> Delete </button>";
                }
                echo "</form></td>";
                echo "</tr>";
            }
        }
        elseif (isset($_POST['showIdRes'])) {
            $sajatFoglalasok = getIdReservations($pdo, $_SESSION["user_id"]);
            foreach ($sajatFoglalasok as $foglalas) {
                echo "<tr>";
                echo "<td>" . $foglalas["parkolohely_szam"] . "</td>";
                echo "<td>" . $foglalas["kezdeti_datum"] . "</td>";
                echo "<td>" . $foglalas["veg_datum"] . "</td>";
                echo "<td>" . $foglalas["rendszam"] . "</td>";
                echo "<td><form method='POST'>";
                echo "<button type='submit' name='deleteReservation' value='" . $foglalas["id"] . "'> Delete </button>";
                echo "</form></td>";
                echo "</tr>";
            }
        }
    ?>
</table>
</body>
</html>
