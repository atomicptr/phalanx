<div>
    <h1 class="text-xl mb-8">{{ __("Meta Builds") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Items") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($builds as $build)
                    <tr>
                        <td>
                            <a href="{{ route("admin.builds.meta.edit", ['build' => $build->id])}}" class="font-bold" wire:navigate>
                                {{ $build->name }}
                            </a>
                        </td>
                        <td>
                            <x-mini-build :build="$build->parseBuild()" />
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.builds.meta.edit", ['build' => $build->id])}}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                @can("can-delete")
                                    <button class="btn join-item" wire:click="delete({{ $build->id }})" wire:confirm="{{ __("Are you sure you want to delete this build?")}}">
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
        <a class="btn btn-primary" href="{{ route("admin.builds.meta.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
