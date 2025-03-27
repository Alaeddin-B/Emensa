<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Ihre E-Mensa</title>
    <link rel="stylesheet" href="css/hauptseite_style.css">

</head>
<body>
<header class="inBody">
    @yield('kopfbereich')
</header>
<hr>
<main class="inBody">
    <div>
        @yield('begruessung')

    </div>
    <div>
        @yield('gerichte')

    </div>
    <div>
        @yield('newsletterAnmeldung')
    </div>
</main>
<footer>
    @yield('fussbereich')
</footer>
</body>
</html>