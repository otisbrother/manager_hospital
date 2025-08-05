@csrf

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label>Mã bệnh nhân</label>
        <input type="text" name="id" value="{{ old('id', $patient->id ?? '') }}" class="w-full border p-2 rounded"
            {{ isset($patient) ? 'readonly' : '' }}>

        {{-- Hiển thị lỗi nếu có --}}
    @if ($errors->has('id'))
        <span class="text-red-500 text-sm">{{ $errors->first('id') }}</span>
    @endif 
    </div>
    <div>
        <label>Họ tên</label>
        <input type="text" name="name" value="{{ old('name', $patient->name ?? '') }}" class="w-full border p-2 rounded">
        @if ($errors->has('name'))
            <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
        @endif
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}" class="w-full border p-2 rounded">
        @if ($errors->has('email'))
            <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div>
        <label>Mật khẩu {{ isset($patient) ? '(để trống nếu không đổi)' : '' }}</label>
        <input type="password" name="password" class="w-full border p-2 rounded" {{ !isset($patient) ? 'required' : '' }}>
        @if ($errors->has('password'))
            <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div>
        <label>Giới tính</label>
        <select name="gender" class="w-full border p-2 rounded">
            <option value="Nam" {{ old('gender', $patient->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
            <option value="Nữ" {{ old('gender', $patient->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
        </select>
        @if ($errors->has('gender'))
            <span class="text-red-500 text-sm">{{ $errors->first('gender') }}</span>
        @endif
    </div>
    <div>
        <label>Ngày sinh</label>
        <input type="date" name="date" value="{{ old('date', $patient->date ?? '') }}" class="w-full border p-2 rounded">
        @if ($errors->has('date'))
            <span class="text-red-500 text-sm">{{ $errors->first('date') }}</span>
        @endif
    </div>
    <div class="col-span-2">
        <label>Địa chỉ</label>
        <textarea name="address" class="w-full border p-2 rounded">{{ old('address', $patient->address ?? '') }}</textarea>
        @if ($errors->has('address'))
            <span class="text-red-500 text-sm">{{ $errors->first('address') }}</span>
        @endif
    </div>
    <div>
        <label>SĐT</label>
        <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" class="w-full border p-2 rounded">
        @if ($errors->has('phone'))
            <span class="text-red-500 text-sm">{{ $errors->first('phone') }}</span>
        @endif
    </div>
    <div>
        <label>Loại bệnh nhân</label>
        <select name="patient_type_id" class="w-full border p-2 rounded">
            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('patient_type_id', $patient->patient_type_id ?? '') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('patient_type_id'))
            <span class="text-red-500 text-sm">{{ $errors->first('patient_type_id') }}</span>
        @endif
    </div>
    <div>
        <label>Mã BHYT (tự động tạo nếu chưa có)</label>
        <input type="text" name="insurance_id" value="{{ old('insurance_id', $patient->insurance_id ?? '') }}" 
               class="w-full border p-2 rounded" placeholder="Nhập mã BHYT (có thể để trống)">
        @if ($errors->has('insurance_id'))
            <span class="text-red-500 text-sm">{{ $errors->first('insurance_id') }}</span>
        @endif
        <small class="text-gray-500">Hệ thống sẽ tự động tạo BHYT nếu mã chưa tồn tại</small>
    </div>
    <div class="col-span-2 text-right">
    <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-600 transition">
        Lưu
    </button>
</div>
</div>
