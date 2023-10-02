<x-layout>
    <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index')]" />

    {{-- aggiungiamo l'attributo x-data per far diventare la card un alpine component --}}
    <x-card x-data="" class="mb-4 text-sm">
        <form x-ref="filters" action="{{ route('jobs.index') }}" method="GET" id="filtering-form">
            <div class="mb-4 grid grid-cols-2 gap-4">
                {{-- 1 --}}
                <div>
                    <div class="mb-1 font-semibold">Search</div>
                    {{-- nb: qui non usiamo i due punti
                    i due punti servono per interpretare una espressione PHP
                    in questo caso vogliamo passare delle semplici stringhe --}}
                    <x-text-input name="search" value="{{ request('search') }}" placeholder="Search for any text"
                        form-ref="filters" />
                </div>
                {{-- 2 --}}
                <div>
                    <div class="mb-1 font-semibold">Salary</div>
                    <div class="flex space-x-2">
                        <x-text-input name="min_salary" value="{{ request('min_salary') }}" placeholder="From"
                            form-ref="filters" />
                        <x-text-input name="max_salary" value="{{ request('max_salary') }}" placeholder="To"
                            form-ref="filters" />
                    </div>
                </div>
                {{-- 3 --}}
                <div class="mb-1 font-semibold">Experience
                    <x-radio-group :options="array_combine(
                        array_map('ucfirst', App\Models\Job::$experience),
                        App\Models\Job::$experience,
                    )" name="experience" />
                </div>
                {{-- 4 --}}
                <div class="mb-1 font-semibold">Category
                    <x-radio-group :options="App\Models\Job::$category" name="category" />
                </div>
            </div>

            <x-button class="w-full">Filter</x-button>
        </form>
    </x-card>
    @foreach ($jobs as $job)
        {{-- le classi sugli slot funzionano solo se il componente ha $attributes->class --}}
        <x-job-card class="mb-4" :$job>
            <div>
                <x-link-button :href="route('jobs.show', $job)">
                    Show
                </x-link-button>
            </div>
        </x-job-card>
    @endforeach
</x-layout>
