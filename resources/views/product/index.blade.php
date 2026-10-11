<x-app-layout>
    <div class="px-72">
        <div class="w-full h-32 bg-gradient-to-tr from-orange-200 to-red-200">

        </div>
        <div class="grid grid-cols-5 space-x-10 mt-10">
            <div class="col-span-1 space-y-7">
                <div class="w-full">
                    <button class="w-full flex items-center justify-between">
                        <h1 class="font-bold">
                            lorem ipsum Dolor
                        </h1>
                    </button>
                    <hr class="mt-2">
                    <ul class="text-sm space-y-2 mt-2">
                        <li>lorem ipsum</li>
                        <li>lorem ipsum</li>
                        <li>lorem ipsum</li>
                    </ul>
                </div>
                <div class="w-full">
                    <button class="w-full flex items-center justify-between">
                        <h1 class="font-bold">
                            lorem ipsum Dolor
                        </h1>
                    </button>
                    <hr class="mt-2">
                    <ul class="text-sm space-y-2 mt-2">
                        <li>lorem ipsum</li>
                        <li>lorem ipsum</li>
                        <li>lorem ipsum</li>
                    </ul>
                </div>
                <div class="w-full">
                    <button class="w-full flex items-center justify-between">
                        <h1 class="font-bold">
                            lorem ipsum Dolor
                        </h1>
                    </button>
                    <hr class="mt-2">
                    <ul class="text-sm space-y-2 mt-2">
                        <li>lorem ipsum</li>
                        <li>lorem ipsum</li>
                        <li>lorem ipsum</li>
                    </ul>
                </div>
            </div>
            <div class="col-span-4 grid grid-cols-3 gap-8">
                @foreach ($products as $product)
                    <article class="w-full bg-white rounded-md border">
                        <a href="{{ route('product.show', $product) }}" class="cursor-pointer">
                            <div class="w-full h-6 bg-gradient-to-tr from-sky-200 to-emerald-200"></div>
                            <div class="p-5">
                                <div class="grid grid-cols-4 text-lg font-bold">
                                    <h1 class="col-span-3">
                                        {{ $product->name }}
                                    </h1>
                                    <h2 class="col-span-1 text-end">
                                        ${{ $product->price }}
                                    </h2>
                                </div>
                                <p class="text-sm text-neutral-500 mt-5">
                                    {{ \Illuminate\Support\Str::words($product->description, 20, '...') }}
                                </p>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </div>     
</x-app-layout>