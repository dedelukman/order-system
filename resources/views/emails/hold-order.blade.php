@component('mail::message')
# Hold Order

Order Anda tidak dapat dilanjutkan, segera lunasi kewajiban hutang Anda.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
