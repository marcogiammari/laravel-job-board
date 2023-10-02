<div class="relative">
    @if ($formId)
        <button type="button"
            onclick="document.getElementById('{{ $name }}').value = ''; document.getElementById('{{ $formId }}').submit();"
            class="absolute right-0 top-0 flex h-full items-center pr-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="h-4 w-4 text-slate-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
    <input type="text" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}"
        id="{{ $name }}"
        class="w-full rounded-md border-0 px-2.5 py-1.5 pr-8 text-sm ring-1 ring-slate-300 placeholder:text-slate-400 focus:ring-2">
</div>
