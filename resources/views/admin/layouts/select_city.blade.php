<div class="form-group">
    <label for="city">Tỉnh/Thành phố:</label><label style="color: red">(*)</label>
    <select class="form-control selectAddress city_id" id="city" name="city_id">
        <option value="" selected>Chọn tỉnh/thành phố</option>
        @foreach ($cities as $city)
            <option value="{{ $city->id }}"
                {{ old('city') == $city->id ? 'selected' : '' }}>
                {{ $city->city_name }}
            </option>
        @endforeach
    </select>
</div>