<?php
/**
 * Mapping of paths to controllers.
 * Note, that the path only supports one level of directory depth:
 *     /demo is ok,
 *     /demo/subpage will not work as expected
 */
session_start();

return array(
    '/'             => "EmensaController@index",
    '/wunschgericht' => "EmensaController@wunschgericht",
    "/demo"         => "DemoController@demo",
    '/dbconnect'    => 'DemoController@dbconnect',
    '/debug'        => 'HomeController@debug',
    '/error'        => 'DemoController@error',
    '/requestdata'   => 'DemoController@requestdata',
    '/anmeldung' => 'AnmeldungController@anmeldung',
    '/anmeldung_verifizieren' => 'EmensaController@anmeldung_verifizieren',
    '/abmeldung' => 'EmensaController@abmeldung',
    '/bewertung' => 'EmensaController@bewertung',
    '/bewertung_speichern' => 'EmensaController@bewertung_speichern',
    '/bewertungen' => 'EmensaController@bewertungen_zeigen',
    '/meinebewertungen' => 'EmensaController@meine_bewertungen_zeigen',
    '/bewertung_loeschen' => 'EmensaController@bewertung_loeschen',
    '/bewertung_hervorheben' => 'EmensaController@bewertung_hervorheben',

    // Erstes Beispiel:
    '/m4_6a_queryparameter' => 'ExampleController@m4_6a_queryparameter',
    '/m4' => 'ExampleController@m4_6a_queryparameter',
    '/m4_7b' => 'ExampleController@m4_7b_kategorie',
    '/m4_7c' => 'ExampleController@m4_7c_gerichte',
    '/m4_7d' => 'ExampleController@m4_7d_pages_switch',


);