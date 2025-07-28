@if (session('error_message'))
    <div class="w-full border border-red-500 text-red-700 rounded p-5 text-sm">
        {{ session('error_message') }}
    </div>
@endif