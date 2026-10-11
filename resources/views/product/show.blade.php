<x-app-layout>
    <div class="w-full px-[30rem] grid grid-cols-5 gap-x-10">
        <div class="w-full col-span-3">
            <div class="w-full h-20 bg-neutral-200 rounded-lg">
            </div>

            <div class="mt-5">
                <p class="text-neutral-600">
                    {!! nl2br($product->description) !!}
                </p>
            </div>
        </div>
        <div class="w-full col-span-2">
            <h1 class="text-xl font-semibold">{{ $product->name }}</h1>
            <h2 class="text-2xl font-bold">
                ${{ $product->price }}
            </h2>

            <form class="w-full mt-5" action="{{ route("paypal.payment") }}" method="post">
                @csrf
                <input type="hidden" name="price" value="{{ $product->price }}"/>
                <button class="w-full h-11 rounded-md bg-blue-600 text-white">
                    Pay with paypal
                </button>
            </form>
        </div>
    </div>
</x-app-layout>