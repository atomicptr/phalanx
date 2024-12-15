<div class="hidden sm:flex" wire:poll.5s>
    @if ($this->can())
        <button class="btn mr-4" disabled wire:loading>
            <span class="loading loading-spinner loading-md"></span>
        </button>
        <button class="btn mr-4" wire:click="deploy()" wire:loading.remove>
            <x-heroicon-o-bolt class="inline-block h-6 w-6 stroke-current" />
            {{ __("Deploy") }}
        </button>
    @else
        <button class="btn mr-4" disabled>
            <x-heroicon-o-bolt class="inline-block h-6 w-6 stroke-current" />
            {{ __("Deploy") }}
        </button>
    @endif
</div>
