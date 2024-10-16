<div>
    <form wire:submit="save">

        <x-input.textfield label="Name" fieldName="form.name" />
        <x-input.textfield label="E-Mail" type="email" fieldName="form.email" />
        <x-input.textfield label="Password" type="password" fieldName="form.password" />
        <x-input.textfield label="Repeat Password" type="password" fieldName="form.passwordRepeat" />

        <x-input.toggle label="Is Admin?" fieldName="form.is_admin" live="true" />

        <div  @if ($this->form->is_admin) class="hidden" @endif>
            <x-input.toggle label="Can Publish Builds" fieldName="form.can_publish" />
            <x-input.toggle label="Can Access Confidential Data" fieldName="form.can_access_confidential" />
            <x-input.toggle label="Can Access Patches" fieldName="form.can_access_patches" />
            <x-input.toggle label="Can Edit Builds" fieldName="form.can_edit_builds" />
            <x-input.toggle label="Can Edit Data" fieldName="form.can_edit_data" />
        </div>

        <x-input.submit />
    </form>
</div>
