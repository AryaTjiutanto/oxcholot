<div class="max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:py-16 mx-auto">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:items-stretch md:grid-cols-3 md:gap-8">
        @foreach ($subscriptions as $subscription)
            <form action="{{ route('subscription.checkout') }}" method="post" class="divide-y bg-white divide-gray-200 rounded-2xl border border-gray-200 shadow-xs">
                @csrf
                <div class="p-6 sm:px-8">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ $subscription->name }}
                        <span class="sr-only">Plan</span>
                    </h2>

                    <p class="mt-2 text-gray-700">{{ $subscription->description }}</p>

                    <p class="mt-2 sm:mt-4">
                        <strong class="text-3xl font-bold text-gray-900 sm:text-4xl"> ${{ $subscription->price }}
                        </strong>

                        <span class="text-sm font-medium text-gray-700">/month</span>
                    </p>

                    <input type="hidden" name="price_id" value="{{ $subscription->price_id }}">
                    <input type="hidden" name="trial_days" value="{{ $subscription->trial_days }}">
                    <button class="mt-4 block rounded-sm border border-indigo-600 bg-indigo-600 px-12 py-3 text-center text-sm font-medium text-white hover:bg-transparent hover:text-indigo-600 focus:ring-3 focus:outline-hidden sm:mt-6">
                        Get Started
                    </button>
                </div>

                <div class="p-6 sm:px-8">
                    <p class="text-lg font-medium text-gray-900 sm:text-xl">What's included:</p>

                    @php
                        $features = json_decode($subscription->features);
                    @endphp

                    <ul class="mt-2 space-y-2 sm:mt-4">
                        @foreach ($features as $key=>$feature)
                            <li class="flex items-center gap-1">
                                @if($feature)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-indigo-700 shadow-sm">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 text-red-700 shadow-sm">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                @endif

                                <span class="text-gray-700"> {{ $key }} </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </form>
        @endforeach
    </div>
</div>
