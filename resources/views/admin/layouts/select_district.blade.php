<div class="form-group">
    <label for="district">Quận/huyện:</label><label style="color: red">(*)</label>
    <select class="form-control selectAddress" id="district" name="district_id">
        <option value="" selected>Chọn quận/huyện</option>
        @foreach ($districts as $district)
            <option value="{{ $district->id }}"
                {{ old('district') == $district->id ? 'selected' : '' }}>
                {{ $district->district_name }}
            </option>
        @endforeach
    </select>
</div>