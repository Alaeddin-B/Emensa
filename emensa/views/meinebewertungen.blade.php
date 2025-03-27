<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Meine Bewertungen</title>
</head>
<body>
<ul>
    @foreach($bewertungen as $bewertung)
        <li style="background-color: {{$bewertung['hervorgehoben'] ? "yellow" : "none"}}">
            <b>{{$bewertung['gerichtName']}}</b><br>
            {{$bewertung['sterne']}} Stern(e)<br>
            {{$bewertung['bemerkung']}}

            <form method="post" action="bewertung_loeschen">
                <button>Bewertung Löschen</button>
                <input name="bewertungid" value="{{$bewertungen['id']}}" hidden="hidden">
            </form>
        </li>
        @if($_SESSION['admin'])
            <form method="post" action="bewertung_hervorheben">
                <input type="submit" value="hervorheben">
                <input type="text" value="{{$bewertung['id']}}" hidden="hidden">
            </form>
        @endif
        <hr>
    @endforeach
</ul>
</body>