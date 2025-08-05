<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block font-semibold">Mã Hóa Đơn</label>
        <input type="text" name="id" value="{{ old('id', optional($bill)->id) }}" class="w-full border px-3 py-2 rounded" required>
    </div>
    <div>
        <label class="block font-semibold">Mã BHYT</label>
        <input type="text" name="health_insurance_id" value="{{ old('health_insurance_id', optional($bill)->health_insurance_id) }}" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label class="block font-semibold">Mã Bệnh Nhân</label>
        <input type="text" name="patient_id" value="{{ old('patient_id', optional($bill)->patient_id) }}" class="w-full border px-3 py-2 rounded" required>
    </div>
    <div>
        <label class="block font-semibold">Mã Đơn Thuốc</label>
        <input type="text" name="prescription_id" value="{{ old('prescription_id', optional($bill)->prescription_id) }}" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label class="block font-semibold">Tổng Tiền (VNĐ)</label>
        <input type="number" name="total" value="{{ old('total', optional($bill)->total) }}" class="w-full border px-3 py-2 rounded" step="0.01">
    </div>
</div>
<div class="flex justify-start items-center gap-4 mt-4">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black px-4 py-2 rounded">
        ✅ Lưu
    </button>
    <a href="{{ route('admin.bills.index') }}" class="bg-gray-400 hover:bg-gray-500 text-black px-4 py-2 rounded">
        ❌ Hủy
    </a>
</div>
