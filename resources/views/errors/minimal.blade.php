
<x-app-layout>
    <div class="text-center">
        <div class="error mx-auto" data-text="@yield('code')">@yield('code')</div>
        <p class="lead text-gray-800 mb-5">@yield('message')</p>
        <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
        <a href={{ route('dashboard') }}>&larr; Back to Dashboard</a>
   </div>
</x-app-layout>
