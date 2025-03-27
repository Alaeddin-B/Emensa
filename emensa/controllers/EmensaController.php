<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/gericht.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/besucher.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/benutzer.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/bewertung.php');

class EmensaController
{
    public function index(RequestData $rd)
    {

//Test für gültigen Namen
        $gueltigeEingabe = true;
        $vorname = "";
        $error = "";
        if(!isset($_SESSION["name"])){
            $_SESSION["name"] = "";
        }
        if(!isset($_SESSION["login_ok"])){
            $_SESSION["login_ok"] = false;
        }
        if (!isset($_SESSION["admin"]))
            $_SESSION["admin"] = false;
        if (isset($rd->getPostData()['vorname'])) {
            $vorname = htmlspecialchars($rd->getPostData()['vorname']);
        }
        if (trim($vorname) === "" && isset($rd->getPostData()['vorname'])) {
            //die("Vorname muss angegeben werden!");
            $error = "Vorname muss angegeben werden!<br>";
            $gueltigeEingabe = false;
        }

//test für gültige E-Mail
        $email = "";
        $emailErr = "";
        if (isset($rd->getPostData()['email'])) {
            $email = htmlspecialchars($rd->getPostData()['email']);
        }
        $isDisposable = false;
        $disposable = array("@trashmail.", "@wegwerfmail.");
        foreach ($disposable as $value) {
            if (str_contains($email, $value)) {
                $isDisposable = true;
            }
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && isset($rd->getPostData()['email']) || $isDisposable) {
            $emailErr = "Invalid email format<br>";
            $gueltigeEingabe = false;
        }
//Speicherung von Newsletter Anmeldedaten
        $erfolg = "";
        if ($gueltigeEingabe && isset($rd->getPostData()['email']) && isset($rd->getPostData()['vorname'])) {
            $erfolg = "Eingabe erfolgreich gespeichert!";
            $file = fopen('../public/daten.txt', 'a');
            $text_to_write = $rd->getPostData()['vorname'] . "|" . $rd->getPostData()['email'] . "|" . $rd->getPostData()['newsletter'] . "\n";
            fwrite($file, $text_to_write);
            fclose($file);
        }

//Aufzählung von Newsletter Anmeldungen
        $anmeldungCounter = 0;
        $dumpFile = "";
        $datenFile = fopen('../public/daten.txt', 'r');

        while (($line = fgets($datenFile)) !== false) {
            $anmeldungCounter++;
        }

//Auf- oder absteigende Darstellung der Gerichtentabelle.
        $reihenfolge = "ASC";
        if (isset($rd->getGetData()['reihenfolge'])) {
            $reihenfolge = $rd->getGetData()['reihenfolge'];
        }

        logger()->info("Zugriff auf der Hauptseite");
        return view('hauptseite', ['reihenfolge' => $reihenfolge, 'allergene' => db_gericht_tabelleFuellen($reihenfolge)['allergies'],
            'anmeldungCounter' => $anmeldungCounter, 'error' => $error, 'emailErr' => $emailErr,
            'anzahlBesucher' => db_besucher_select_count(), 'anzahlGerichten' => db_gericht_select_count(),
            'tabelleFuellen' => db_gericht_tabelleFuellen($reihenfolge)['ausgabe'], 'name' => $_SESSION['name']]);
    }

    public function wunschgericht()
    {
        return view('wunschgericht', []);
    }

    public function anmeldung_verifizieren(RequestData $rd)
    {
        $_SESSION['login_ok'] = false;
        $email = $rd->getPostData()['loginemail'];
        $passwort = $rd->getPostData()['passwort'];

        if (db_anmelden($email, $passwort)) {
            $_SESSION['login_ok'] = true;
            logger()->info("Benutzer erfolgreich angemeldet!");
            header("Location: http://localhost:8056/");
            return $this->index($rd);

        } else
            logger()->warning("Anmeldung fehlgeschlagen!");

        return view('anmeldung', ['anmeldungerror' => "E-Mail oder Passwort nicht korrekt"]);
    }
    public function abmeldung(RequestData $rd)
    {

        $_SESSION['login_ok'] = false;
        logger()->info("Benutzer erfolgreich abgemeldet");
        $_SESSION['name'] = "";
        header("Location: http://localhost:8056/");
        return $this->index($rd);
    }
    public function bewertung(RequestData $rd)
    {

        if ($_SESSION['login_ok']) {
            if (isset($rd->getGetData()['gerichtid'])) {
                $gericht_id = htmlspecialchars($rd->getGetData()['gerichtid']);
                                                          return view('bewertung', ["gerichtid" => $gericht_id,
                                                              "data" => db_gericht_select_id($gericht_id)
                ]);
            }
            return $this->index($rd);
        }
        else{
            header("Location: http://localhost:8056/anmeldung");
            return view('anmeldung', []);
        }
    }
    public function bewertung_speichern(RequestData $rd)
    {
        $gericht_id = htmlspecialchars($rd->getGetData()['gerichtid']);
        $bewertung = htmlspecialchars($rd->getGetData()['bewertung']);
        $bemerkung = htmlspecialchars($rd->getGetData()['bemerkung']);

        db_bewertung_speichern($gericht_id, $bemerkung, $bewertung);
        logger()->info("Bewertung gespeichert!");
        header("Location: http://localhost:8056/");
    }
    public function bewertungen_zeigen()
    {
        return view('bewertungen', ['bewertungen' => db_bewertungen_listen()]);
    }
    public function meine_bewertungen_zeigen()
    {
        return view('bewertungen', ['bewertungen' => db_meine_bewertungen_listen()]);
    }
    public function bewertung_loeschen(RequestData $rd)
    {
        $bewertung_id = htmlspecialchars($rd->getPostData()['bewertung_id']);
        db_bewertung_loeschen($bewertung_id);
        return $this->bewertungen_zeigen();
    }
    public function meine_bewertung_loeschen(RequestData $rd)
    {
        $bewertung_id = htmlspecialchars($rd->getPostData()['bewertung_id']);
        db_bewertung_loeschen($bewertung_id);
        return $this->meine_bewertungen_zeigen();
    }
    public function bewertung_hervorheben(RequestData $rd)
    {
        $bewertung_id = htmlspecialchars($rd->getPostData()['bewertung_id']);
        db_bewertung_hervorheben($bewertung_id);
        return $this->bewertungen_zeigen();
    }
}