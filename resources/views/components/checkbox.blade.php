<div class="form-check {{ $class }}">
    <input
        class="form-check-input {{ $classInput }}"
        name="{{ $name }}"
        id="{{ $prefix.str_replace(array('[',']'), '', $name) }}"
        type="checkbox"
        value="{{ $value ?? 1 }}"
        {{ $checked == true ? 'checked' : '' }}
        {{ $attributes }}
    />
    <label class="form-check-label {{ $classLabel }}" for="{{ $prefix.str_replace(array('[',']'), '', $name) }}">
        {{ $caption }}
    </label>
</div>
