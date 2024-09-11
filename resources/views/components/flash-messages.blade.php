@if (session()->has("message"))
    <div class="flex flex-row justify-center">
        {{-- Force Tailwind to keep these: alert-info alert-success --}}
        <div class="alert alert-{{ !session("messageType") ? "info" : session("messageType") }} my-8 max-w-lg">
            @if (session("messageType") === "success")
                <x-heroicon-o-check class="w-6 h-6" />
            @else
                <x-heroicon-o-information-circle class="w-6 h-6" />
            @endif
            {{ session("message") }}
        </div>
    </div>
@endif
