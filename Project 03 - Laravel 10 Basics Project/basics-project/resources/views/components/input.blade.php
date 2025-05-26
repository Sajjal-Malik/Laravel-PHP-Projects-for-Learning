<div class="form-group">
    <label for="exampleInputName1">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" class="form-control" id="exampleInputName1" placeholder="{{ $placeholder }}">
    <span class="text-danger">
        {{-- @error('name')
            {{ $message }}
        @enderror --}}
    </span>
</div>