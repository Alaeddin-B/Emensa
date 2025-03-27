<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Bewertung</title>
    <style>
        @media (max-width: 600px) {
            .bewertung-grid {
                display: grid;
                grid-auto-rows: auto auto;
            }
        }
    </style>
</head>
<body>
<form method="get" action="bewertung_speichern">
    <div class="bewertung-grid">
        <label for="bemerkung" style="font-size: 20px; font-weight: bold">Bemerkung:</label>
        <input type="text" id="bemerkung" name="bemerkung"/><br><br>
    </div>
    <div class="bewertung-grid">
        <label for="sterne" style="font-size: 20px; font-weight: bold">Sterne:</label>
        <select name="bewertung">
            <option value="4">★★★★(sehr gut)</option>
            <option value="3">★★★(gut)</option>
            <option value="2">★★(schlecht)</option>
            <option value="1">★(sehr schlecht)</option>
        </select><br><br>
    </div>
    <input type="submit" value="Senden">
    <input name="gerichtid" value="{{$gerichtid}}" hidden="hidden">
</form>
<div>
    <p>Bewertung für: {{$data['name']}}</p>
    <img src="img/gerichte/{{$data['bildname']}}.jpg" alt="Bild vom Gericht">
</div>
</body>