<x-layout>
    <h1 class="text-xl mb-8">{{ __("Weapons") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th width="32">Icon</th>
                    <th>Name</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="avatar">
                            <div class="mask mask-squircle h-12 w-12">
                                <img src="https://cdn.jsdelivr.net/gh/atomicptr/dauntless-builder/assets/icons/weapons/gnasher/RagingBlade.png?build=1725555024279" />
                            </div>
                        </div>
                    </td>
                    <td>
                        <a href="" class="font-bold">
                            Gnasher Sword
                        </a>
                    </td>
                    <th>
                        <div class="join">
                            <a class="btn join-item">
                                <x-heroicon-o-pencil class="w-6 h-6" />
                            </a>
                            <a class="btn join-item">
                                <x-heroicon-o-trash class="w-6 h-6" />
                            </a>
                        </div>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</x-layout>
