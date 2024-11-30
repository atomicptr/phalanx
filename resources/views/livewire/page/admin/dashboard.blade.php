<div>
    <style>
        @php
            echo \Jfcherng\Diff\DiffHelper::getStyleSheet();
        @endphp
    </style>

    <div class="mb-8">
        Here could be some content like a dashboard :)
    </div>

    @can("is-admin")
        <h2 class="text-2xl mb-4">
            {{ _("Audit Log") }}
        </h2>
        <div class="flex flex-col gap-2">
            @foreach (\App\Service\AuditService::logs() as $audit)
                <div class="flex flex-col gap-2">
                    <div class="flex flex-row gap-2">
                        <div class="flex flex-row gap-2">
                            <img class="w-6 h-6 rounded-full" src="{{ $audit->user->gravatarUrl() }}" />
                            <div>
                                {{ $audit->user->name }}
                            </div>
                        </div>

                        <div>
                            @switch($audit->event)
                                @case("created")
                                    created the {{ $audit->model->name }}
                                    @if ($audit->item !== null)
                                        <a href="{{ $audit->model->link }}" class="link-primary">
                                            {{ $audit->change->new['name'] }}
                                        </a>
                                    @else
                                        <span class="line-through">
                                            {{ $audit->change->new['name'] }}
                                        </span>
                                    @endif

                                    @break
                                @case("updated")
                                    updated the {{ $audit->model->name }}

                                    @isset($audit->change->old["name"])
                                        <span class="line-through">
                                            {{ $audit->change->old["name"] }}
                                        </span>
                                    @endisset

                                    <a href="{{ $audit->model->link }}" class="link-primary">
                                        {{ $audit->item?->name }}
                                    </a>

                                    @break
                                @case("deleted")
                                    deleted the {{ $audit->model->name }} 
                                    <span class="line-through">
                                        {{ $audit->change->old['name'] }}
                                    </span>
                                    @break
                                @default
                                    {{ $audit->event }}
                            @endswitch
                        </div>

                        <div class="text-gray-600">
                            ({{ $audit->date }})
                        </div>

                        @if (strlen($audit->change->diff) > 0)
                            <div class="btn btn-xs btn-ghost" wire:click="logToggleAudit({{ $audit->id }})">
                                @if ($this->open === $audit->id)
                                    <x-heroicon-o-x-mark class="w-4 h-4" />
                                @else
                                    <x-heroicon-o-eye class="w-4 h-4" />
                                @endif
                            </div>
                        @endif
                    </div>
                    @if ($this->open === $audit->id && strlen($audit->change->diff) > 0)
                        {!! $audit->change->diff !!}
                    @endif
                </div>
            @endforeach
        </div>
    @endcan
</div>
