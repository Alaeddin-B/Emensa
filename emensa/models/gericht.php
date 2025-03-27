<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gericht_select_all() {
    try {
        $link = connectdb();

        $sql = 'SELECT id, name, beschreibung FROM gericht ORDER BY name';
        $result = mysqli_query($link, $sql);

        $data = mysqli_fetch_all($result, MYSQLI_BOTH);

        mysqli_close($link);
    }
    catch (Exception $ex) {
        $data = array(
            'id'=>'-1',
            'error'=>true,
            'name' => 'Datenbankfehler '.$ex->getCode(),
            'beschreibung' => $ex->getMessage());
    }
    finally {
        return $data;
    }

}
function db_gericht_select_all_() {
    try {
        $link = connectdb();

        $sql = 'SELECT name, preisintern FROM gericht where preisintern > 2 ORDER BY name desc';
        $result = mysqli_query($link, $sql);

        $data = mysqli_fetch_all($result, MYSQLI_BOTH);

        mysqli_close($link);
    }
    catch (Exception $ex) {
        $data = array(
            'id'=>'-1',
            'error'=>true,
            'name' => 'Datenbankfehler '.$ex->getCode(),
            'beschreibung' => $ex->getMessage());
    }
    finally {
        return $data;
    }

}
function db_gericht_select_count() {
    try {
        $link = connectdb();

        $sql = "SELECT COUNT(*) AS anzahl FROM gericht ";
        $result = mysqli_query($link, $sql);

        $row = mysqli_fetch_assoc($result);

        mysqli_close($link);
    }
    catch (Exception $ex) {
        $data = array(
            'id'=>'-1',
            'error'=>true,
            'name' => 'Datenbankfehler '.$ex->getCode(),
            'beschreibung' => $ex->getMessage());
    }
    finally {
        return $row['anzahl'];
    }

}

function db_gericht_tabelleFuellen($reihenfolge)
{

    $allergies = [];
    //vervindung mit der Datenbank erstellen
    $link = connectdb();

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }

    $reihenfolge = mysqli_real_escape_string($link, $reihenfolge);
    $sql = "SELECT id, name, preisintern, preisextern, bildname FROM gericht order by name " . $reihenfolge . " LIMIT 5 ";

    $result = mysqli_query($link, $sql); //mysqli_real_escape_string() erstellt errors weil es string zurückgibt
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    //Wir haben hier eine extra Tabelle in unserer Datenbank erstellt, um einfacher mit diesen Funktionen zu arbeiten
    //gerichten_allergene ist ein JOIN von Gericht, Allergen, und gericht_hat_allergen
    $sql2 = "SELECT gericht_id, gericht_hat_allergen.code, allergen.name as name FROM gericht_hat_allergen
                join allergen where allergen.code = gericht_hat_allergen.code";
    $result2 = mysqli_query($link, $sql2);
    if (!$result2) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }

    $ausgabe = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $allergen = "";
        while ($row2 = mysqli_fetch_assoc($result2)) {
            if ($row2["gericht_id"] == $row["id"]) {
                $allergen .= $row2["code"] . ", ";

                if (!in_array($row2["name"], $allergies))
                    $allergies[] = $row2["name"];

            }
        }
        $allergen = rtrim($allergen, ", ");
        mysqli_data_seek($result2, 0);
        $bewertungLink = "";
        $_SESSION["login_ok"] && ($bewertungLink = "/bewertung?gerichtid=". $row['id']);
        $imagePath = 'img/gerichte/'. $row['bildname']. '.jpg';
        if ($row['bildname'] != NULL && file_exists($imagePath))
            $ausgabe [] = ["spalte1" => [$row['name'], $allergen, $bewertungLink], "spalte2" => number_format((float)$row['preisintern'], 2, ',', ''), "spalte3" => number_format((float)$row['preisextern'], 2, ',', ''), "spalte4" => $imagePath];
        else
            $ausgabe [] = ["spalte1" => [$row['name'], $allergen, $bewertungLink], "spalte2" => number_format((float)$row['preisintern'], 2, ',', ''), "spalte3" => number_format((float)$row['preisextern'], 2, ',', ''), "spalte4" => "img/gerichte/00_image_missing.jpg"];
    }

    mysqli_free_result($result);
    mysqli_close($link);

    return ['ausgabe' => $ausgabe,
        'allergies' => $allergies];
}

function db_gericht_select_id($gericht_id)
{
    $link = connectdb();

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $gericht_id = mysqli_real_escape_string($link, $gericht_id);
    $sql = "SELECT * FROM gericht WHERE id = " . $gericht_id;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return mysqli_fetch_assoc($result);
}

