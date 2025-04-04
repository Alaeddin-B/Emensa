<?php
const GET_PARAM_WUNSCH = "wunsch";
const GET_PARAM_EMAIL = "email";
const GET_PARAM_NAME = "name";
const GET_PARAM_BESCH = "beschreibung";

$wunsch = "";
$email = "";
$name = "";
$besch = "";
$currentDateTime = date('Y-m-d');


if (isset($_POST[GET_PARAM_WUNSCH])) {
    $wunsch = $_POST[GET_PARAM_WUNSCH];
}
if (isset($_POST[GET_PARAM_EMAIL])) {
    $email = $_POST[GET_PARAM_EMAIL];
}
if (isset($_POST[GET_PARAM_NAME])) {
    $name = $_POST[GET_PARAM_NAME];
}
if (isset($_POST[GET_PARAM_BESCH])) {
    $besch = $_POST[GET_PARAM_BESCH];
}
if (!empty($_POST)) {

    $link = mysqli_connect("localhost", // Host der Datenbank
        "root",                 // Benutzername zur Anmeldung
        "M3_PWort123",    // Passwort
        "emensawerbeseite"      // Auswahl der Datenbanken (bzw. des Schemas)
// optional port der Datenbank
    );

    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    $ersteller_id = 0;
    $sql = "Select * From ersteller";
    $result = mysqli_query($link, $sql);

    //Überprüfen ob E-Mail existiert, wenn ja, dann speichere seine ersteller_id
    $email_exists = false;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['email'] == $email) {
            $email_exists = true;
            $ersteller_id = $row['id'];
            break;
        }
    }
    //wenn E-Mail nicht existiert: ersteller hinzufügen und sein id speichern
    if (!$email_exists) {
        if ($name != "") {
            $sql = "INSERT INTO ersteller (name, email) VALUES ('$name', '$email')";
        } else $sql = "INSERT INTO ersteller (email) VALUES ('$email')";

        mysqli_query($link, $sql);
        $sql = "SELECT * FROM ersteller";
        $result = mysqli_query($link, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['email'] == $email) {
                $ersteller_id = $row['id'];
                break;
            }
        }
    }
    elseif ($email_exists && $name != "") {
        $sql = "UPDATE ersteller SET name = '$name' WHERE id = '$ersteller_id'";
        mysqli_query($link, $sql);
    }
    $sql2 = "INSERT INTO wunschgericht (erstellungsdatum, beschreibung, name, ersteller_id) VALUEs ('$currentDateTime', '$besch' , '$wunsch', '$ersteller_id')";
    mysqli_query($link, $sql2);
    mysqli_free_result($result);
    mysqli_close($link);

}
?>

<!DOCTYPE html>
<html>
<head lang="de">
    <meta charset="UTF-8">
    <title>wunschgericht</title>
</head>
<body>
<form method="post">

    <label for="name">Ihr Name(Optional):</label>
    <input type="text" id="name" name="name">

    <label for="email">Ihre E-Mail:</label>
    <input type="email" id="email" name="email" required>
    <br><br>
    <label for="wunsch">Wunsch eingeben:</label>
    <input type="text" id="wunsch" name="wunsch" required>

    <label for="besch">Beschreibung eingeben:</label>
    <input type="text" id="besch" name="beschreibung" required>

    <input type="submit" name="submit" value="Wunsch abschicken">


</form>
<a href="/">Zurück</a>
</body>
</html>
