<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Bewertungen</title>
</head>
<body>
<ul>
    @foreach($bewertungen as $bewertung)
        <li style="background-color: {{$bewertung['hervorgehoben'] ? "yellow" : "none"}}">
            <b>{{$bewertung['gerichtName']}}</b><br>
            {{$bewertung['sterne']}} Stern(e)<br>
            {{$bewertung['bemerkung']}}
            @if($bewertung['benutzerId'] == $_SESSION['user_id'])
                <form method="post" action="bewertung_loeschen">
                    <button type="submit">Bewertung Löschen</button>
                    <input name="bewertung_id" type="text" value="{{$bewertung['id']}}" hidden="hidden">
                </form>
            @endif
            @if($_SESSION['admin'])
                <form method="post" action="bewertung_hervorheben">
                    <input type="submit" value="hervorheben">
                    <input type="text" name="bewertung_id" value="{{$bewertung['id']}}" hidden="hidden">
                </form>
            @endif
        </li>
        <hr>
    @endforeach
</ul>
</body>