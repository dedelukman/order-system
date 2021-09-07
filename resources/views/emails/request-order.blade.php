@component('mail::message')
# {{ $details['title'] }}</h1>

<p>{{ $details['orderNo'] }}</p>

<p>{{ $details['body'] }}</p>



@component('mail::button', ['url' => $details['url']])
{{ $details['button'] }}
@endcomponent


Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
