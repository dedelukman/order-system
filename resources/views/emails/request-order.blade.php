@component('mail::message')
# {{ $details['title'] }}</h1>

<p>{{ $details['orderNo'] }}</p>

<p>{{ $details['body'] }}</p>



@component('mail::button', ['url' => $details['url']])
{{ $details['button'] }}
@endcomponent

Note : {{ $details['note'] }}


Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
