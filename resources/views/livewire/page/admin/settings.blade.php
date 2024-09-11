<div>
    <h1 class="text-xl">{{ __("Settings") }}</h1>

    <form wire:submit="save">
        <div class=my-4>
            <span class="font-bold">{{ __("Name") }}</span> {{ Auth::user()->name }}
        </div>

        <div class=my-4>
            <span class="font-bold">{{ __("E-Mail") }}</span> {{ Auth::user()->email }}
        </div>

        <x-input.textfield label="Password" fieldName="password" type="password" />
        <x-input.textfield label="Repeat password" fieldName="passwordRepeat" type="password" />

        <x-input.submit />
    </form>
</div>
