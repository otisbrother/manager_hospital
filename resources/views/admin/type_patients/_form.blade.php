@csrf
<div class="mb-4">
    <label class="block font-semibold mb-1">Mã loại</label>
    <input type="text" name="id" value="{{ old('id', $type->id ?? '') }}" 
           class="w-full border p-2 rounded" {{ isset($type) ? 'readonly' : '' }} required>
</div>
<div class="mb-4">
    <label class="block font-semibold mb-1">Tên loại</label>
    <input type="text" name="name" value="{{ old('name', $type->name ?? '') }}" 
           class="w-full border p-2 rounded" required>
</div>
<button class="bg-green-600 text-black px-4 py-2 rounded shadow">
    {{ isset($type) ? 'Cập nhật' : 'Lưu' }}
</button>
<a href="{{ route('admin.type_patients.index') }}" class="ml-3 text-gray-500 hover:underline">Hủy</a>
