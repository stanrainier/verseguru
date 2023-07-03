@foreach($tests as $test)
<h1> {{ $tests->user_username }} </h1>
<h1> {{ $tests->user_password }} </h1>
<h1> {{ $tests->user_id }} </h1>
@endforeach