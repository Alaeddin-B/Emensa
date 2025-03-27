@extends('layouts.emensaLayout')

@section('kopfbereich')
    @if($_SESSION['login_ok'])
        <div class="anmeldung_grid">
            <p>Angemeldet als: {{$name}}</p>
            <a href="/meinebewertungen">Meine Bewertungen</a>
            <a href="/abmeldung" class="button">Abmelden</a>
        </div>
    @else
        <a href="/anmeldung" class="button">Anmelden</a>
    @endif
    <div class="unserHeader-grid">
        <div>
            <img src="img/LOGOstudierendenwerk.jpg" alt="E-Mensa Logo">
        </div>
        <div class="links">
            <ul>
                <li><a href="#ankuendigung">Ankündigung</a></li>
                <li><a href="#speisen">Speisen</a></li>
                <li><a href="#zahlen">Zahlen</a></li>
                <li><a href="#newsletterSection">Kontakt</a></li>
                <li><a href="#wichtig">Wichtig für uns</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('begruessung')
    <h1 id="ankuendigung">
        Bald gibt es Essen auch Online
    </h1>
    <div class="ankundigung">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
            et dolore maana aliqua. Ut enim ad minim veniam, quis nostrud exercitation Ullawico laboris nisi ut
            aliquip ex ea comodo consequat. Duis aute ivure dolor in reprehenderit in voluptate velit esse cillum
            dolore eu fugiat nulla pariatur. Excepteur Sint occaecat cupidatat non proident, sunt in culpa qui
            officia deserunt mollit anim id est laborum. <br>
            Sed ut perspiciatis Unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae
            dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit,
            Sed quia consequUntur magni dolores eos qui ratione voluptatem sequi nesciunt.
        </p>
    </div>
@endsection

@section('gerichte')
    <h1 id="speisen">
        Köstlichkeiten, die Sie erwarten
    </h1>
    <div class="reihenfolgeLinkGrid">
        <form method="get"><!--action="werbeseite.php"-->
            <!-- Ändert die Reihenfolge der dargestellten Gerichte -->
            <select name="reihenfolge" onchange="this.form.submit()">
                <option value="ASC" {{$reihenfolge == "ASC" ? " selected" : ""}} >Aufsteigend</option>
                <option value="DESC" {{$reihenfolge == "DESC" ? " selected" : ""}} >Absteigend</option>
            </select>
            <!--    //<input type="submit" value="Bestätigen">-->
        </form>
        <a href="wunschgericht">Ein Wunschgericht hinzufügen</a>
    </div>
    <table>
        <tr>
            <th></th>
            <th>Preis intern</th>
            <th>Preis extern</th>
            <th>Foto</th>
        </tr>

        @foreach($tabelleFuellen as $antrag)
            <tr>
                <td>
                    {{$antrag['spalte1'][0]}}
                    <br>
                    <p><b>Allergene:</b> {{$antrag['spalte1'][1]}}</p>
                    <a href="{{$antrag['spalte1'][2]}}">Gericht bewerten</a>
                </td>
                <td>
                    {{$antrag['spalte2']}}
                </td>
                <td>
                    {{$antrag['spalte3']}}
                </td>
                <td>
                    <img src="{{$antrag['spalte4']}}" alt="gericht bild">
                </td>
            </tr>
        @endforeach

    </table>
    <div style="display: grid; grid-template-columns: 70% 30%">
        <div>
            <p>Verwendete Allergene: </p>
            <ul>
                @foreach($allergene as $allergy)
                    <li>{{$allergy}}</li>
                @endforeach
            </ul>
        </div>
        <a  href="/bewertungen">Alle Bewertungen ansehen</a>
    </div>
    <h1 id="zahlen">E-Mensa in Zahlen</h1>
    <div class=zahlen-grid>
        <div>{{$anzahlBesucher}} Besuche</div>
        <div> {{$anmeldungCounter}} Anmeldungen zum Newsletter</div>
        <div>{{$anzahlGerichten}} Speisen</div>
    </div>
@endsection

@section('newsletterAnmeldung')
    <h1 id="newsletterSection">Interesse geweckt? Wir informieren Sie!</h1>
    <form method="post">
        <div class="eingabe">
            <div>
                <label for="vorname">Ihr Name:</label>
                <input type="text" id="vorname" name="vorname" size="28" placeholder="Vorname" required>
            </div>
            <div>
                <label for="email">Ihre E-Mail:</label>
                <input type="text" id="email" name="email" size="28" required>
            </div>
            <div>
                <label for="newsletter">Newsletter bitte in:</label>
                <select name="newsletter" id="newsletter">
                    <option value="deutsch">Deutsch</option>
                    <option value="englisch">Englisch</option>
                    <option value="spanisch">Spanisch</option>
                </select>
            </div>
        </div>
        <div class="check_button">
            <div class="check_text">
                <p class="fehlermeldung">{!!$error!!}</p>
                <p class="fehlermeldung">{!! $emailErr !!}</p>
                <input type="checkbox" id="datenschutz" name="datenschutz" value="datenschutz" required>
                <label for="datenschutz">Den Datenschutzbestimmungen stimme ich zu</label>
            </div>
            <div>
                <input id="_button" type="submit" value="Zum Newsletter anmelden">
            </div>
        </div>
    </form>
    <h1 id="wichtig">
        Das ist uns wichtig
    </h1>
    <div class="wichtig">
        <ul>
            <li>Beste frische saisonale Zutaten</li>
            <li>Ausgewogene abwechslungsreiche Gerichte</li>
            <li>Sauberkeit</li>
        </ul>
    </div>
    <h1 class="text4">
        Wir freuen uns auf Ihren Besuch!
    </h1>
@endsection

@section('fussbereich')

    <hr>
    <footer>
        <ul class="footer">
            <li>(c) E-Mensa GmbH</li>
            <li>Alaeddin Bahrouni, Ivan Dyulgerov</li>
            <li><a href="https://www.fh-aachen.de/">Impressum</a></li>
        </ul>
    </footer>
@endsection