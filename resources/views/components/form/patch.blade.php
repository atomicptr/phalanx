<div>
    <form wire:submit="save">

        <x-input.textfield label="Name" fieldName="form.name" />
        <x-input.toggle label="Is live?" fieldName="form.live" />
        <x-input.toggle label="Is confidential?" fieldName="form.confidential" />

        <x-input.submit />
    </form>
</div>
