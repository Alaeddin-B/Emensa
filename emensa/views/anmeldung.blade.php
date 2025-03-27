<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Anmeldung</title>
</head>
<body>
<form method="post" action="anmeldung_verifizieren">
    <label for="email">Ihre Email:</label>
    <input type="email" id="email" name="loginemail">

    <label for="passwort">Ihr Passwort:</label>
    <input type="password" id="passwort" name="passwort">
    <input type="submit" value="Anmeldung">
</form>
{{$anmeldungerror}}
</body>