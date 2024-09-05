<!DOCTYPE html>

<title>
	@if ($title ?? null)
		{{ $title }} || {{ Config::get("app.name") }}
	@else
		{{ Config::get("app.name") }}
	@endif
</title>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles

<div>
	{{ $slot }}
</div>

@livewireScripts
