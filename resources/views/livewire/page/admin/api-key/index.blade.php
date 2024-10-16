<div>
    <h1 class="text-xl mb-8">{{ __("API Key") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __("Name") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apiKeys as $apiKey)
                    <tr>
                        <td>
                            <a href="{{ route("admin.api-key.edit", ["apiKey" => $apiKey]) }}" class="font-bold" wire:navigate>
                                {{ $apiKey->name }}
                            </a>
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.api-key.edit", ["apiKey" => $apiKey]) }}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                <button class="btn join-item" wire:click="delete({{ $apiKey->id }})" wire:confirm="{{ __("Are you sure you want to delete this API Key?")}}">
                                    <x-heroicon-o-trash class="w-6 h-6" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex flex-row mt-8">
        <a class="btn btn-primary" href="{{ route("admin.api-key.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
