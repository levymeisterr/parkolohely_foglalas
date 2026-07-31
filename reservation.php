<?php
require_once("database.php");

$pdo = connect();

function createReservation($pdo,$kezdetiDatum,$vegDatum,$felhasznalo_id = 2,$parkolohely_szam = 1){
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
    $sql = "SELECT foglalas.parkolohely_szam,foglalas.kezdeti_datum,foglalas.veg_datum, felhasznalo.rendszam, foglalas.id FROM foglalas, felhasznalo WHERE foglalas.felhasznalo_id = felhasznalo.id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
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