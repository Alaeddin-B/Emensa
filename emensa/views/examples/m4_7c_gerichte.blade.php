
<ul>
    @if(empty($gerichte))
        <h3>Es sind keine Gerichte vorhanden</h3>
    @else
        @foreach($gerichte as $gericht)
            <li>{{$gericht['name']}} für {{$gericht['preisintern']}}€</li>
        @endforeach
    @endif
</ul>