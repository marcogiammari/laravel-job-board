<div class="relative">
    @if ($type != 'textarea')
        @if ($formRef)
            <button type="button"
                x-on:click="$refs['input-{{ $name }}'].value = ''; $refs['{{ $formRef }}'].submit()"
                class="absolute right-0 top-0 flex h-full items-center pr-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="h-4 w-4 text-slate-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
        <input x-ref="input-{{ $name }}" type="{{ $type }}" name="{{ $name }}"
            value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" id="{{ $name }}" @class(['w-full rounded-md border-0 px-2.5 py-1.5 ring-1 text-sm placeholder:text-slate-400 focus:ring-2', 
            'pr-8' => $formRef,
            'ring-slate-300' => !$errors->has($name),
            'ring-red-300' => $errors->has($name),
            ])>
    @else
        <textarea id="{{ $name }}" name="{{$name}}" @class(['w-full rounded-md border-0 px-2.5 py-1.5 ring-1 text-sm placeholder:text-slate-400 focus:ring-2', 
        'pr-8' => $formRef,
        'ring-slate-300' => !$errors->has($name),
        'ring-red-300' => $errors->has($name),
        ])>{{ old($name, $value) }}</textarea>
    @endif

    @error($name)
    <div class="mt-1 text-xs text-red-500">
        {{$message}}
    </div>
    @enderror
</div>
