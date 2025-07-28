<x-app-layout>
    <div class="w-full px-72 py-10">
        <x-success-message />
        <x-error-message />
        <div class="w-full p-5 rounded-lg bg-white border flex justify-between items-center mt-6">
            <div class="w-fit">
                <h1 class="text-lg font-semibold">
                    Hello {{ Auth::user()->name }}
                </h1>
                <p class="text-sm text-neutral-600">
                    @if ($active_subscription)
                        You're currently subscribed to the <b>{{ $active_subscription->name }}</b> plan
                        @if ($subscription->onTrial())
                            {{ ' (Trial) ' }}
                        @endif
                        until
                        {{ Carbon\Carbon::createFromTimestamp($stripe_subscription->current_period_end)->format('h:i a, d M Y') }}
                    @endif
                </p>
            </div>
            @if ($active_subscription)
                @if ($subscription->onGracePeriod())
                    <form action="{{ route('subscription.resume') }}" method="post">
                        @csrf
                        <button
                            class="px-7 h-12 bg-neutral-200 border border-neutral-200 hover:bg-transparent rounded-md text-xs duration-150">
                            Continue Subscription
                        </button>
                    </form>
                @else
                    <form action="{{ route('subscription.cancel') }}" method="post">
                        @csrf
                        <button
                            class="px-7 h-12 bg-neutral-200 border border-neutral-200 hover:bg-transparent rounded-md text-xs duration-150">
                            Cancel Subscription
                        </button>
                    </form>
                @endif
            @endif
        </div>
        <div class="w-full grid grid-cols-3 gap-5 mt-5">
            @foreach ($subscriptions as $subscription)
                <div class="w-full border border-neutral-300 bg-white rounded-md p-5">
                    <h1 class="font-bold">
                        {{ $subscription->name }}
                    </h1>
                    <p>
                        {{ $subscription->description }}
                        <br>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat minus consequatur recusandae
                    </p>
                    @if ($subscription->price_id == $active_subscription->price_id)
                        <div
                            class="w-full h-12 border border-neutral-300 duration-150 rounded-md mt-6 flex justify-center items-center">
                            You've subscribed this plan
                        </div>
                    @elseif($subscription->price < $active_subscription->price)
                        @if ($subscription->price_id)
                            <form action="{{ route('subscription.swap') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ $subscription->price_id }}" name="price_id">
                                <button
                                    class="w-full h-12 border border-neutral-300 hover:bg-neutral-300 duration-150 rounded-md mt-6 flex justify-center items-center">
                                    Downgrade
                                </button>
                            </form>
                        @else
                            <form action="{{ route('subscription.cancel') }}" method="post">
                                @csrf
                                <button
                                    class="w-full h-12 border border-neutral-300 hover:bg-neutral-300 duration-150 rounded-md mt-6 flex justify-center items-center">
                                    Downgrade to Free
                                </button>
                            </form>
                        @endif
                    @elseif($subscription->price > $active_subscription->price)
                        <form action="{{ route('subscription.swap') }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $subscription->price_id }}" name="price_id">
                            <button
                                class="w-full h-12 border border-neutral-300 hover:bg-neutral-300 duration-150 rounded-md mt-6 flex justify-center items-center">
                                Upgrade
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
