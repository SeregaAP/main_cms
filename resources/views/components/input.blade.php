<div class="form_group">
    <label>
        {{ $label }}
        <input 
            placeholder="{{ $placeholder }}" 
            type="{{ $type }}" 
            name="{{ $name }}" 
            class="{{ $class }}"
            @if($required) required @endif
            value="{{ $value ?: old($name) }}"
            {{ $attributes->whereDoesntStartWith('required') }}
        >
    </label>
    
    @error($name)
        <div class="text-danger mt-1">
            {{ $message }}
        </div>
    @enderror
</div>