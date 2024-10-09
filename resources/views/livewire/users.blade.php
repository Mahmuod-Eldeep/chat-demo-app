<div class="max-w-6xl mx-auto my-16">

    <h5 class="text-center text-5xl font-bold py-3">Users</h5>

    @if ($users->isEmpty())
        <!-- إذا لم يكن هناك مستخدمين -->
        <div class="text-center text-gray-500 text-xl py-6">
            There are no users yet.
        </div>
    @else
        <!-- عرض المستخدمين إذا كانت المجموعة غير فارغة -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2 ">
            @foreach ($users as $key => $user)
                <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow">
                    <div class="flex flex-col items-center pb-10">
                        <img src="https://i.pinimg.com/564x/e3/d3/79/e3d379303b584e7c5ca4f71a24071d67.jpg" alt="image"
                            class="w-24 h-24 mb-2.5 rounded-full shadow-lg">
                        <h5 class="mb-1 text-xl font-medium text-gray-900">
                            {{ $user->name }}
                        </h5>
                        <span class="text-sm text-gray-500">{{ $user->email }}</span>

                        <!-- عرض حالة الاتصال -->
                        @if ($user->is_online)
                            <span class="text-sm text-green-500 font-bold">Online</span>
                        @else
                            <span class="text-sm text-red-500 font-bold">Offline</span>
                        @endif

                        <div class="flex mt-4 space-x-3 md:mt-6">
                            <x-secondary-button>
                                Add Friend
                            </x-secondary-button>
                            <x-primary-button wire:click="message({{ $user->id }})">
                                Message
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
