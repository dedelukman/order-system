@component('mail::message')
# Process Order

Mohon Segera diproses Order CV. Indah Jaya Lestari

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
