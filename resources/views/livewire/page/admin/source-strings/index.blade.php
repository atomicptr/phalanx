<div>
    <h1 class="text-xl mb-8">{{ __("Patch") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __("Identifier") }}</th>
                    <th>{{ __("Content") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sourceStrings as $sourceString)
                    <tr>
                        <td>
                            <a href="{{ route("admin.source-string.edit", ["sourceString" => $sourceString]) }}" class="font-bold" wire:navigate>
                                {{ $sourceString->ident }}
                            </a>
                        </td>
                        <td>
                            {{ $sourceString->content }}
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.source-string.edit", ["sourceString" => $sourceString]) }}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                @can("can-delete")
                                    <button class="btn join-item" wire:click="delete({{ $sourceString->id }})" wire:confirm="{{ __("Are you sure you want to delete this source string?")}}">
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
        <a class="btn btn-primary" href="{{ route("admin.source-string.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
