<div class="form-group">
    <label for="ward">Xã/phường:</label><label style="color: red">(*)</label>
    <select class="form-control ward_id" id="ward" name="ward_id">
        <option value="" selected>Chọn xã/phường</option>
        @foreach ($wards as $ward)
            <option value="{{ $ward->id }}"
                {{ old('ward') == $ward->id ? 'selected' : '' }}>
                {{ $ward->ward_name }}
            </option>
        @endforeach
    </select>
</div>