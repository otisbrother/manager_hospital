<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            ✏️ Chỉnh sửa chi tiết sổ khám bệnh
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6 px-6 bg-white rounded shadow">
        <form action="{{ route('admin.detail-medicalrecords.update', [$detail->medical_record_id, $detail->patient_id, $detail->exam_date]) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.detail_medicalrecords._form', ['detail' => $detail])
        </form>
    </div>
    @endsection
</x-app-layout>
