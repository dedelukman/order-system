@component('mail::layout')
{{-- Header --}}
@slot('header')
<x-jet-application-mark style="width: 100px; margin-top: 15px;" />
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} <a href="https://sekarayu.co.id/"> PT. Sekar Ayu Sentosa.</a> @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
