<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏️ Sửa Khoa</h2>
    </x-slot>
  @section('content')
    <form method="POST" action="{{ route('admin.departments.update', $department->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Tên khoa</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $department->name }}" required>
        </div>
        <div class="mb-4">
            <label>Vị trí</label>
            <input type="text" name="location" class="w-full border p-2 rounded" value="{{ $department->location }}">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    @endsection
</x-app-layout>
