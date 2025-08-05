@props(['relative' => null])

@php
    $isEdit = !is_null($relative);
@endphp

<div class="w-full">
    <form action="{{ $isEdit 
        ? route('admin.relatives.update', ['patient_id' => $relative->patient_id, 'name' => $relative->name]) 
        : route('admin.relatives.store') }}"
          method="POST" class="space-y-4 w-full">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <!-- <h1>*Lưu ý khi thêm mã bệnh nhân cho thân nhân, mã bắt buộc nằm trong (BN10200 - BN10279)</h1> -->

        <div>
            <label for="patient_id" class="block font-semibold">Mã bệnh nhân</label>
            <input type="text" name="patient_id" id="patient_id" class="w-full border p-2 rounded"
                   value="{{ old('patient_id', $relative->patient_id ?? '') }}" 
                   {{ $isEdit ? 'readonly' : '' }} required>
        </div>

        <div>
            <label for="name" class="block font-semibold">Họ tên</label>
            <input type="text" name="name" id="name" class="w-full border p-2 rounded"
                   value="{{ old('name', $relative->name ?? '') }}"
                   {{ $isEdit ? 'readonly' : '' }} required>
        </div>

        <div>
            <label class="block font-semibold">Giới tính</label>
            <select name="gender" class="w-full border p-2 rounded" required>
                <option value="">-- Chọn giới tính --</option>
                <option value="Nam" {{ old('gender', $relative->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gender', $relative->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div>
            <label for="dob" class="block font-semibold">Ngày sinh</label>
            <input type="date" name="dob" id="dob" class="w-full border p-2 rounded"
                   value="{{ old('dob', $relative->dob ?? '') }}" required>
        </div>

        <div>
            <label for="relationship" class="block font-semibold">Quan hệ</label>
            <input type="text" name="relationship" id="relationship" class="w-full border p-2 rounded"
                   value="{{ old('relationship', $relative->relationship ?? '') }}" required>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="{{ $isEdit ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }} text-black px-4 py-2 rounded">
                {{ $isEdit ? 'Cập nhật' : 'Lưu' }}
            </button>
            <a href="{{ route('admin.relatives.index') }}" class="ml-3 text-gray-600 hover:underline">Hủy</a>
        </div>
    </form>
</div>
