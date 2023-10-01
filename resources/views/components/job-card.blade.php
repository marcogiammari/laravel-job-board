<x-card class="mb-4">
    <div class="mb-4 flex justify-between">
        <h2 class="text-lg font-medium">{{ $job->title }}</h2>
        <div class="text-slate-500">
            ${{ number_format($job->salary) }}
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between text-sm text-slate-500">
        <div class="flex space-x-4">
            <div>Company Name</div>
            <div>{{ $job->location }}</div>
        </div>
        <div class="flex space-x-1 text-xs">
            <x-tag>
                {{ Str::ucfirst($job->experience) }}
            </x-tag>
            <x-tag class="rounded-md border px-2 py-1">
                {{ $job->category }}
            </x-tag>
        </div>
    </div>
    {{-- inserisce dei <br> quando il testo va a capo
    necessita di interpolare con {!! !!} per funzionare --}}
    <p class="mb-4 text-sm text-slate-500">
        {!! nl2br(e($job->description)) !!}
    </p>

    {{ $slot }}
</x-card>
