<div class="min-h-screen flex items-center justify-center bg-base-200">
    <form wire:submit="login">
        <div class="card w-full max-w-sm shadow-xl bg-base-100">
            <div class="card-body">
                <div class="mb-4">
                    <x-navbar-logo />
                </div>

                @if (session()->has("error"))
                    <div role="alert" class="alert alert-error mb-4">
                        <x-heroicon-o-exclamation-circle class="w-4 h-4" />
                        <span>
                            {{ session("error") }}
                        </span>
                    </div>
                @endif

                <div class="form-control w-full max-w-xs">
                    <label class="input input-bordered flex items-center gap-2 {{ $errors->has("email") ? "input-error" : "" }}">
                        <x-heroicon-o-envelope class="w-4 h-4" />
                        <input wire:model="email" type="text" class="grow" placeholder="{{ __("E-Mail") }}" :value="old('email')" />
                    </label>

                    @if ($errors->has("email"))
                        <div class="label">
                            <span class="label-text-alt {{ $errors->has("email") ? "text-error" : "" }}">
                                {{ $errors->first("email") }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="form-control w-full max-w-xs">
                    <label class="input input-bordered flex items-center gap-2 {{ $errors->has("password") ? "input-error" : "" }}">
                        <x-heroicon-o-key class="w-4 h-4" />
                        <input wire:model="password" type="password" class="grow" placeholder="{{ __("Password") }}" />
                    </label>

                    @if ($errors->has("password"))
                        <div class="label">
                            <span class="label-text-alt {{ $errors->has("password") ? "text-error" : "" }}">
                                {{ $errors->first("password") }}
                            </span>
                        </div>
                    @endif
                </div>

                <div class="form-control mt-6">
                    <button class="btn btn-primary">{{ __("Login") }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
