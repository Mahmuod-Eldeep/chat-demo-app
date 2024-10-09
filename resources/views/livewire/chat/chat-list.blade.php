<div x-data="{ type: 'all', query: @entangle('query') }" x-init="setTimeout(() => {

    conversationElement = document.getElementById('conversation-' + query);


    //scroll to the element

    if (conversationElement) {

        conversationElement.scrollIntoView({ 'behavior': 'smooth' });

    }

}, 200);



Echo.private('users.{{ Auth()->User()->id }}')
    .notification((notification) => {
        if (notification['type'] == 'App\\Notifications\\MessageRead' || notification['type'] == 'App\\Notifications\\MessageSent') {

            window.Livewire.emit('refresh');
        }
    });" class="flex flex-col transition-all h-full overflow-hidden">

    <header class="px-3 z-10 bg-white sticky top-0 w-full py-2">

        <div class="border-b justify-between flex items-center pb-2">

            <div class="flex items-center gap-2">
                <h5 class="font-extrabold text-2xl">Users Chats</h5>
            </div>

            <button>

                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    viewBox="0 0 16 16">
                    <path
                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                </svg>

            </button>

        </div>

        {{-- Filters --}}

        <div class="flex gap-3 items-center overflow-x-scroll p-2 bg-white">

            <button @click="type='all'" :class="{ 'bg-blue-100 border-0 text-black': type == 'all' }"
                class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border ">
                All
            </button>
            <button @click="type='deleted'" :class="{ 'bg-blue-100 border-0 text-black': type == 'deleted' }"
                class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border ">
                Deleted
            </button>

        </div>

    </header>

    <main class=" overflow-y-scroll overflow-hidden grow  h-full relative " style="contain:content">

        {{-- chatlist  --}}

        <ul class="p-2 grid w-full spacey-y-2">

            @if ($conversations)

                @foreach ($conversations as $key => $conversation)
                    <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}"
                        class="py-3 hover:bg-gray-50 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->id ? 'bg-gray-100/70' : '' }}">
                        <a href="#" class="shrink-0">
                            <x-avatar
                                src="data:image/png;base64,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" />
                        </a>

                        <aside class="grid grid-cols-12 w-full">

                            <a href="{{ route('chat', $conversation->id) }}"
                                class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">

                                {{-- name and date  --}}
                                <div class="flex justify-between w-full items-center">

                                    <h6 class="truncate font-medium tracking-wider text-gray-900">
                                        {{ $conversation->getReceiver()->username }}
                                    </h6>

                                    <small
                                        class="text-gray-700">{{ $conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans() }}
                                    </small>

                                </div>

                                {{-- Message body --}}

                                <div class="flex gap-x-2 items-center">

                                    @if ($conversation->messages?->last()?->sender_id == auth()->id())
                                        @if ($conversation->isLastMessageReadByUser())
                                            {{-- double tick  --}}
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                                    <path
                                                        d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                                </svg>
                                            </span>
                                        @else
                                            {{-- single tick  --}}
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                    @endif

                                    <p class="grow truncate text-sm font-[100]">
                                        {{ $conversation->messages?->last()?->body ?? ' ' }}
                                    </p>

                                    {{-- unread count --}}
                                    @if ($conversation->unreadMessagesCount() > 0)
                                        <span
                                            class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-blue-500 text-white">
                                            {{ $conversation->unreadMessagesCount() }}
                                        </span>
                                    @endif

                                </div>

                            </a>

                            {{-- Dropdown --}}

                            <div class="col-span-1 flex flex-col text-center my-auto">

                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor"
                                                class="bi bi-three-dots-vertical w-7 h-7 text-gray-700"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            </svg>

                                        </button>
                                    </x-slot>

                                    <x-slot name="content">

                                        <div class="w-full p-1">

                                            <button
                                                class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">

                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-person-circle"
                                                        viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                        <path fill-rule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                                    </svg>
                                                </span>

                                                View Profile

                                            </button>
                                            <button onclick="confirm('Are you sure?')||event.stopImmediatePropagation()"
                                                wire:click="deleteByUser('{{ encrypt($conversation->id) }}')"
                                                class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">

                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-trash-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                                    </svg>
                                                </span>

                                                Delete

                                            </button>

                                        </div>

                                    </x-slot>
                                </x-dropdown>

                            </div>

                        </aside>

                    </li>
                @endforeach
            @else
            @endif

        </ul>

    </main>
</div>
