<?php
function db_besucher_select_count() {
    try {
        $ip = $_SERVER['REMOTE_ADDR'];
        $webbrowser = $_SERVER['HTTP_USER_AGENT'];
        date_default_timezone_set('Europe/Berlin');
        $currentDateTime = date('Y-m-d H:i:s');


        $link = connectdb();
        $sql = "INSERT INTO besucher (ip, datum, browser) VALUEs ('$ip', '$currentDateTime', '$webbrowser')";
        if (!mysqli_query($link, $sql)) {
            echo "Error beim Hinzufügen: ", mysqli_error($link);
        }
        $sql = "SELECT COUNT(*) AS anzahl FROM besucher ";
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
