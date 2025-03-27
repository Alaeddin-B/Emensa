<?php
function db_anmelden($email, $passwort)
{
    $link = connectdb();

    mysqli_begin_transaction($link);

    $korrekt = false;
    $email = mysqli_real_escape_string($link, $email);
    $passwort = sha1("salty" . $passwort);
    $name = "";
    $id = "";
    $admin = "";
    $currentDateTime = mysqli_real_escape_string($link, date('Y-m-d H:i:s'));


    $sql = "select email, passwort, name, id, admin from benutzer where email = '$email'";
    $result = mysqli_query($link, $sql);

    if (!empty($row = mysqli_fetch_array($result)) && $passwort == $row['passwort']) {
        $korrekt = true;
        $name = $row['name'];
        $id = $row['id'];
        $admin = $row['admin'];

        $sql = "update benutzer 
                set letzteanmeldung = '$currentDateTime' 
                where email = '$email'";
        mysqli_query($link, $sql);
        $sql = "call anzahlanmeldungen(". $row['id'] .")";
        mysqli_query($link, $sql);
    }
    elseif (!empty($row) && $passwort != $row['passwort'])
    {
        $sql = "update benutzer 
                set letzterfehler = '$currentDateTime', 
                    anzahlfehler = anzahlfehler + 1 
                where email = '$email'";
        mysqli_query($link, $sql);
    }
    $_SESSION['name'] = $name;
    $_SESSION['user_id'] = $id;
    $_SESSION['admin'] = $admin;
    mysqli_commit($link);
    return $korrekt;
}