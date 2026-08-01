<?php
require_once("database.php");

$pdo = connect();

function selectAvailableSpace($pdo,$kezdetiDatum,$vegDatum){
    $sql = "SELECT p.szam FROM parkolohely p WHERE NOT EXISTS (SELECT 1 FROM foglalas f WHERE f.parkolohely_szam = p.szam AND f.kezdeti_datum < :veg AND f.veg_datum > :kezdet) ORDER BY p.szam ASC LIMIT 1;";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":veg" => $vegDatum,
        ":kezdet" => $kezdetiDatum
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["szam"];
}

function createReservation($pdo,$kezdetiDatum,$vegDatum,$felhasznalo_id){
    if ($vegDatum<$kezdetiDatum){
        echo "Please enter a valid time period!";
        return;
    }
    $parkolohely_szam = selectAvailableSpace($pdo,$kezdetiDatum,$vegDatum);
    if ($parkolohely_szam === null) {
        echo "No available parking space for this time period.";
        return;
    }
        $sql = "INSERT INTO foglalas (kezdeti_datum, veg_datum, felhasznalo_id, parkolohely_szam) VALUES (:kezdeti_datum, :veg_datum, :felhasznalo_id, :parkolohely_szam)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':kezdeti_datum' => $kezdetiDatum,
            ':veg_datum' => $vegDatum,
            ':felhasznalo_id' => $felhasznalo_id,
            ':parkolohely_szam' => $parkolohely_szam
        ]);
}

function getAllReservations($pdo){
    $sql = "SELECT foglalas.parkolohely_szam,foglalas.kezdeti_datum,foglalas.veg_datum, felhasznalo.rendszam, foglalas.id, felhasznalo.id as uid FROM foglalas, felhasznalo WHERE foglalas.felhasznalo_id = felhasznalo.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getIdReservations($pdo,$userId){
    $sql = "SELECT foglalas.parkolohely_szam,foglalas.kezdeti_datum,foglalas.veg_datum, felhasznalo.rendszam, foglalas.id FROM foglalas, felhasznalo WHERE foglalas.felhasznalo_id = felhasznalo.id AND foglalas.felhasznalo_id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $userId
    ]);
    $result = $stmt->fetchAll();
    return $result;
}

function deleteReservation($pdo,$id){
    $sql = "DELETE FROM foglalas WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);
    echo "SIKERES TÖRLÉS";
}


?>