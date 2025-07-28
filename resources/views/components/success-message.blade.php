@if (session('success_message'))
    <div class="w-full border border-green-500 text-green-700 rounded p-5 text-sm">
        {{ session('success_message') }}
    </div>
@endif
