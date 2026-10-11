<div class="max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:py-16 mx-auto">
    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-1 grid grid-cols-2 gap-2 w-full p-5 bg-white border rounded-lg">
            <button class="w-full h-11 bg-slate-950 border border-slate-950 hover:bg-transparent hover:text-black text-white text-sm rounded-md duration-100" wire:click="sendEvent('success', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus, suscipit?')">
                Success
            </button>
            <button class="w-full h-11 bg-red-500 border border-red-500 hover:bg-transparent hover:text-black text-white text-sm rounded-md duration-100" wire:click="sendEvent('error', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Temporibus, suscipit?')">
                Fail
            </button>
        </div>
        <div
        x-data="{
            messageIsVisible : false,
            message : '',
            type: '',
            eventHandler(type, message) {
                this.messageIsVisible = true;
                this.type = type;
                this.message = message;
            }
        }"
        class="col-span-2 w-full p-5 bg-white border rounded-lg" @event-changed.window="eventHandler($event.detail.type, $event.detail.message)">
            <div class="w-full bg-neutral-50 border rounded-md min-h-10 p-2" x-show="messageIsVisible" :class="type == 'success' ? 'border-emerald-400' : 'border-red-500'">
                <p x-text="message"></p>
            </div>
        </div>
    </div>
</div>
