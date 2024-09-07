@props(['checked'])

@if ($checked)
    <span class="badge badge-success w-10 h-10">
        <x-heroicon-o-check class="w-6 h-6" />
    </span>
@else
    <span class="badge badge-error w-10 h-10">
        <x-heroicon-o-x-mark class="w-6 h-6" />
    </span>
@endif
