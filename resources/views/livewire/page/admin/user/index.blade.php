<div>
    <h1 class="text-xl mb-8">{{ __("Users") }}</h1>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __("Avatar") }}</th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Is Administrator") }}</th>
                    <th>{{ __("Can Publish Builds") }}</th>
                    <th>{{ __("Can Access Confidential Data") }}</th>
                    <th>{{ __("Can Access Patches") }}</th>
                    <th>{{ __("Can Edit Builds") }}</th>
                    <th>{{ __("Can Edit Data") }}</th>
                    <th width="32"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img src="{{ $user->gravatarUrl()  }}" />
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route("admin.user.edit", ["user" => $user]) }}" class="font-bold" wire:navigate>
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>
                            <x-ok-check :checked="$user->is_admin" />
                        </td>
                        <td>
                            <x-ok-check :checked="$user->is_admin || $user->can_publish" />
                        </td>
                        <td>
                            <x-ok-check :checked="$user->is_admin || $user->can_access_confidential" />
                        </td>
                        <td>
                            <x-ok-check :checked="$user->is_admin || $user->can_access_patches" />
                        </td>
                        <td>
                            <x-ok-check :checked="$user->is_admin || $user->can_edit_builds" />
                        </td>
                        <td>
                            <x-ok-check :checked="$user->is_admin || $user->can_edit_data" />
                        </td>
                        <td>
                            <div class="join">
                                <a class="btn join-item" href="{{ route("admin.user.edit", ["user" => $user]) }}" wire:navigate>
                                    <x-heroicon-o-pencil class="w-6 h-6" />
                                </a>
                                @can("can-delete")
                                    <button class="btn join-item" wire:click="delete({{ $user->id }})" wire:confirm="{{ __("Are you sure you want to delete this User?")}}">
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
        <a class="btn btn-primary" href="{{ route("admin.user.new") }}" wire:navigate>
            <x-heroicon-o-plus class="w-6 h-6" />
            {{ __("New") }}
        </a>
    </div>
</div>
