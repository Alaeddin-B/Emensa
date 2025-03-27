<html>
<head>
<title>
m4_7b
</title>
</head>
<style>
    .row_odd{
        font-weight: bold;
    }
</style>
<body>
<div>
    <ul>
    @foreach($meals as $meal)
        <li class="row_{{$loop->even ? 'even' : 'odd'}}">
            {{$meal['name']}}
        </li>
    @endforeach
    </ul>

</div>
</body>
</html>