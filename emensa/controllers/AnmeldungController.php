<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../models/benutzer.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../controllers/Emensacontroller.php');


class AnmeldungController
{
    public function anmeldung(RequestData $rd)
    {
//        $email = $rd->getPostData()['loginemail'];
        $error = "";
        return view('anmeldung', ['anmeldungerror' => $error]);
    }


}