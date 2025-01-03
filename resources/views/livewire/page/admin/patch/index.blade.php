<div>
    <h1 class="text-xl mb-8">{{ __("Patch") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Is live?") }}</th>
                    <th>{{ __("Is confidential?") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patches as $patch)
                    <tr>
                        <td>
                            <a href="{{ route("admin.patch.edit", ["patch" => $patch]) }}" class="font-bold" wire:navigate>
                                {{ $patch->name }}
                            </a>
                        </td>
                        <td>
                            <x-ok-check :checked="$patch->live" />
                        </td>
                        <td>
                            <x-ok-check :checked="$patch->confidential" />
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.patch.edit", ["patch" => $patch]) }}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                @can("can-delete")
                                    <button class="btn join-item" wire:click="delete({{ $patch->id }})" wire:confirm="{{ __("Are you sure you want to delete this patch?")}}">
                                        <x-heroicon-o-trash class="w-6 h-6" />
                                    </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex flex-row mt-8">
        <a class="btn btn-primary" href="{{ route("admin.patch.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
