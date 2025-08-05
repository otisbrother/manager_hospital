<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ Thêm Khoa</h2>
    </x-slot>
  @section('content')
    <form method="POST" action="{{ route('admin.departments.store') }}">
        @csrf
        <div class="mb-4">
            <label>Mã khoa</label>
            <input type="text" name="id" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Tên khoa</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Vị trí</label>
            <input type="text" name="location" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
  @endsection  
</x-app-layout>
