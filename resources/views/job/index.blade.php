<x-layout>
    @foreach ($jobs as $job)
        {{-- le classi sugli slot funzionano solo se il componente ha $attributes->class --}}
        <x-card class="mb-4">
            {{ $job->title }}
        </x-card>
    @endforeach
</x-layout>
