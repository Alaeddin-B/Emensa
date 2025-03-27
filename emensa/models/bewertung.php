<?php

function db_bewertung_speichern($gericht_id, $bemerkung, $sterne)
{
    $link = connectdb();
    $currentDateTime = mysqli_real_escape_string($link, date('Y-m-d H:i:s'));
    $user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);
    $bemerkung = mysqli_real_escape_string($link, $bemerkung);
    $sterne = mysqli_real_escape_string($link, $sterne);
    $sql = "INSERT INTO bewertung (gerichtId, bemerkung, sterne, zeitpunkt, benutzerId) 
                VALUES ('$gericht_id', '$bemerkung', '$sterne', '$currentDateTime', '$user_id')";
    mysqli_query($link, $sql);
}

function db_bewertungen_listen()
{
    $link = connectdb();
    $sql = "SELECT bewertung.hervorgehoben as hervorgehoben, bewertung.benutzerId as benutzerId, bewertung.id as id, bewertung.sterne as sterne, bewertung.bemerkung as bemerkung, gericht.name as name FROM bewertung
                JOIN gericht ON bewertung.gerichtId = gericht.id ORDER BY bewertung.zeitpunkt desc LIMIT 30 ";
    $result = mysqli_query($link, $sql);
    $bewertungen = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bewertungen [] = ['sterne' => $row["sterne"], 'bemerkung' => $row["bemerkung"], 'gerichtName' => $row["name"], 'id' => $row["id"], 'benutzerId' => $row["benutzerId"], 'hervorgehoben' => $row["hervorgehoben"]];
    }
    return $bewertungen;
}

function db_meine_bewertungen_listen()
{
    $link = connectdb();
    $sql = "SELECT bewertung.hervorgehoben as hervorgehoben, bewertung.benutzerId as benutzerId, bewertung.id as id, bewertung.sterne as sterne, bewertung.bemerkung as bemerkung, gericht.name as name 
                FROM bewertung
                JOIN gericht ON bewertung.gerichtId = gericht.id 
                WHERE bewertung.benutzerId =" . $_SESSION['user_id'] . "
                ORDER BY bewertung.zeitpunkt desc LIMIT 30 ";
    $result = mysqli_query($link, $sql);
    $bewertungen = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bewertungen [] = ['sterne' => $row["sterne"], 'bemerkung' => $row["bemerkung"], 'gerichtName' => $row["name"], 'id' => $row["id"], 'benutzerId' => $row["benutzerId"], 'hervorgehoben' => $row["hervorgehoben"]];
    }
    return $bewertungen;
}

function db_bewertung_loeschen($bewertung_id)
{
    $link = connectdb();
    $bewertung_id = mysqli_real_escape_string($link, $bewertung_id);
    $sql = "DELETE FROM bewertung WHERE id = '$bewertung_id'";
    mysqli_query($link, $sql);
}

function db_bewertung_hervorheben($bewertung_id)
{
    if ($_SESSION['admin']) {
        $link = connectdb();
        $bewertung_id = mysqli_real_escape_string($link, $bewertung_id);
        $sql = "UPDATE bewertung SET hervorgehoben = !hervorgehoben WHERE id = '$bewertung_id'";
        mysqli_query($link, $sql);
    }
}