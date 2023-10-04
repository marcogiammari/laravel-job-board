<div>
    @if ($allOption)
        <label for="{{ $name }}" class="mb-1 flex items-center">
            <input type="radio" name="{{ $name }}" value="" @checked(!request($name)) />
            <span class="ml-2">All</span>
        </label>
    @endif

    {{-- usiamo il metodo del component WithLabels come variabile --}}
    {{-- ora che è un array associativo usiamo il label per gestire la maiuscola --}}
    {{-- nb: esempio a scopo didattico, bastava usare Str::ucfirst() --}}
    @foreach ($optionsWithLabels as $label => $option)
        <label for="{{ $name }}" class="mb-1 flex items-center">
            <input type="radio" name="{{ $name }}" value="{{ $option }}" @checked($option === ($value ?? request($name))) />
            <span class="ml-2">{{ $label }}</span>
        </label>
    @endforeach

    @error($name)
        <div class="mt-1 text-xs text-red-500">
            {{ $message }}
        </div>
    @enderror
</div>
