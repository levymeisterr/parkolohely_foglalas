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
            $vegDatum,
            $_SESSION["user_id"]
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
    <link rel="stylesheet" href="style/style.css" type="text/css">
    <title>Reservation</title>
</head>
<body>
<h1>Reservations</h1>
<form method="POST" class="form-container">
    <label for="kezdeti_datum">Kezdet:</label>
    <input type="datetime-local" id="kezdeti_datum" name="kezdeti_datum" required>
    <br>
    <label for="veg_datum">Vége:</label>
    <input type="datetime-local" id="veg_datum" name="veg_datum" required>
    <br>
    <button type="submit" name="createReservation">Reserve a parking space!</button>
</form>

<div class="button-container">
    <form method="POST">
        <button type="submit" name="showAllRes">Show all reservations</button>
    </form>
    <form method="POST">
        <button type="submit" name="showIdRes">Show my reservations</button>
    </form>
</div>

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
            if(count($foglalasok) == 0) {
                $nores = "There are no reservations yet!";
            }else{
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
        }
        elseif (isset($_POST['showIdRes'])) {
            $sajatFoglalasok = getIdReservations($pdo, $_SESSION["user_id"]);
            if (count($sajatFoglalasok) == 0) {
                $nores = "You have no reservations!";
            }else{
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
        }
    ?>
</table>

<?php
    if (isset($nores)) {
       echo htmlspecialchars($nores);
    }
?>
</body>
</html>
