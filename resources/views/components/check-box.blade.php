<div class="check_input_group">
    <label for="{{ $name }}">
        {{ $label }}
        <input    {{ $checked ? 'checked' : '' }} class="checkbox" type="checkbox" name="{{ $name }}" id="{{ $name }}">
    </label>
</div>