<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');


class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        /*
           Wenn Sie hier landen:
           bearbeiten Sie diese Action,
           so dass Sie die Aufgabe löst
        */

        return view('examples..m4_7a_queryparameter', [
            'request'=>$rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }
    public function m4_7b_kategorie(RequestData $rd){
        $meals = db_kategorie_select_all_aufsteigend();
        return view('examples.m4_7b_kategorie', ['meals' => $meals]);
    }
    public function m4_7c_gerichte(RequestData $rd){
        $gerichte = db_gericht_select_all_();
        if(is_null($gerichte)){
            $gerichte[] = "Es sind keine Gerichte vorhanden";
        }
        return view('examples.m4_7c_gerichte', ['gerichte' => $gerichte]);
    }
    public function m4_7d_pages_switch(RequestData $rd){
        $no = 1;
        if (isset($rd->getGetData()['no']))
            $no = $rd->getGetData()['no'];

        if($no == '2')
            return view('examples.pages.m4_7d_page_2', []);
        else return view('examples.pages.m4_7d_page_1', []);
    }
}