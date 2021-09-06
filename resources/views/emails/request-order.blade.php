@component('mail::message')
# Request Order

Mohon Konfirmasi Request Order atas CV. Indah Jaya Lestari senilai Rp. 2.000.000.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/order/create/27'])
Konfirmasi
@endcomponent


Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
