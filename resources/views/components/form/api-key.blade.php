<div>
    <form wire:submit="save">

        <x-input.textfield label="Name" fieldName="form.name" />

        @if (isset($this->apiKey))
            <h3 class="text-xl mt-8 mb-4">{{ __("API Key") }}</h3>

            <input class="input input-bordered w-full max-w-lg" disabled value="{{ $this->apiKey->api_key }}" />
        @endif

        <x-input.submit />
    </form>
</div>
