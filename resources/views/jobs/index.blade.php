<x-layout>
    <x-breadcrumbs class="mb-4" :links="['Jobs' => route('jobs.index')]" />

    <x-card class="mb-4 text-sm">
        <form action="{{ route('jobs.index') }}" method="GET">
            <div class="mb-4 grid grid-cols-2 gap-4">
                {{-- 1 --}}
                <div>
                    <div class="mb-1 font-semibold">Search</div>
                    {{-- nb: qui non usiamo i due punti
                    i due punti servono per interpretare una espressione PHP
                    in questo caso vogliamo passare delle semplici stringhe --}}
                    <x-text-input name="search" value="{{ request('search') }}" placeholder="Search for any text" />
                </div>
                {{-- 2 --}}
                <div>
                    <div class="mb-1 font-semibold">Salary</div>
                    <div class="flex space-x-2">
                        <x-text-input name="min_salary" value="{{ request('min_salary') }}" placeholder="From" />
                        <x-text-input name="max_salary" value="{{ request('max_salary') }}" placeholder="To" />
                    </div>
                </div>
                {{-- 3 --}}
                <div class="mb-1 font-semibold">Experience
                    <x-radio-group :options="App\Models\Job::$experience" name="experience" />
                </div>
                {{-- 4 --}}
                <div class="mb-1 font-semibold">Category
                    <x-radio-group :options="App\Models\Job::$category" name="category" />
                </div>
            </div>

            <button class="w-full">Filter</button>
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
