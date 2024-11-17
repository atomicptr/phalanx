@props(['build'])

@php($data = \App\Service\BuildService::fetch($build))

<div class="flex flex-row gap-2">
    @if ($data->weapon1?->icon)
        <img class="w-8 h-8" src="{{ $data->weapon1->icon }}" alt="{{ $data->weapon1->name }}" />
    @endif
    @if ($data->weapon2?->icon)
        <img class="w-8 h-8" src="{{ $data->weapon2->icon }}" alt="{{ $data->weapon2->name }}" />
    @endif
    @if ($data->head?->icon)
        <img class="w-8 h-8" src="{{ $data->head->icon }}" alt="{{ $data->head->name }}" />
    @endif
    @if ($data->torso?->icon)
        <img class="w-8 h-8" src="{{ $data->torso->icon }}" alt="{{ $data->torso->name }}" />
    @endif
    @if ($data->arms?->icon)
        <img class="w-8 h-8" src="{{ $data->arms->icon }}" alt="{{ $data->arms->name }}" />
    @endif
    @if ($data->legs?->icon)
        <img class="w-8 h-8" src="{{ $data->legs->icon }}" alt="{{ $data->legs->name }}" />
    @endif
    @if ($data->lanternCore?->icon)
        <img class="w-8 h-8" src="{{ $data->lanternCore->icon }}" alt="{{ $data->lanternCore->name }}" />
    @endif
</div>
