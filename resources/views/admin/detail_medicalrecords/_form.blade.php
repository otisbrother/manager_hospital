<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block font-semibold">Mã Sổ (medical_record_id)</label>
        <input type="text" name="medical_record_id" value="{{ old('medical_record_id', optional($detail)->medical_record_id) }}" class="w-full border px-3 py-2 rounded" required>
    </div>
    <div>
        <label class="block font-semibold">Mã Bệnh Nhân</label>
        <input type="text" name="patient_id" value="{{ old('patient_id', optional($detail)->patient_id) }}" class="w-full border px-3 py-2 rounded" required>
    </div>
    <div>
        <label class="block font-semibold">Ngày Khám</label>
        <input type="date" name="exam_date" value="{{ old('exam_date', optional($detail)->exam_date ? \Carbon\Carbon::parse($detail->exam_date)->format('Y-m-d') : '') }}" class="w-full border px-3 py-2 rounded" required>
    </div>
    <div>
        <label class="block font-semibold">Mã Đơn Thuốc</label>
        <input type="text" name="prescription_id" value="{{ old('prescription_id', optional($detail)->prescription_id) }}" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label class="block font-semibold">Tên Bệnh</label>
        <input type="text" name="disease_name" value="{{ old('disease_name', optional($detail)->disease_name) }}" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label class="block font-semibold">Mã Khoa</label>
        <input type="text" name="department_id" value="{{ old('department_id', optional($detail)->department_id) }}" class="w-full border px-3 py-2 rounded" required>
    </div>
</div>
<div class="flex justify-start items-center gap-4 mt-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">
        ✅ Lưu
    </button>
    <a href="{{ route('admin.detail-medicalrecords.index') }}" class="bg-gray-400 hover:bg-gray-500 text-black px-4 py-2 rounded">
        ❌ Hủy
    </a>
</div>
