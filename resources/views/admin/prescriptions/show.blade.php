<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Chi tiết đơn thuốc</h2>
    </x-slot>
@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6 space-y-4">
         
            
            <div><strong>Mã đơn:</strong> {{ $prescription->id }}</div>
            <div><strong>Mã BS:</strong> {{ $prescription->doctor->doctor_id ?? 'N/A' }}</div>
            <div><strong>Mã BN:</strong> {{ $prescription->patient->patient_id ?? 'N/A' }}</div>
            <div><strong>Ngày tạo:</strong> {{ $prescription->created_at->format('d/m/Y') }}</div>

            <div class="mt-4">
                <h3 class="font-semibold text-lg mb-2">Thuốc kê trong đơn:</h3>
                @if ($prescription->details && $prescription->details->isNotEmpty())
                    <ul class="list-disc ml-6">
                        @foreach ($prescription->details as $detail)
                            <li>{{ $detail->quantity ?? 0 }} x {{ $detail->medicine->name ?? 'N/A' }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>Không có thuốc nào.</p>
                @endif
            </div>
        </div>
    </div>
  @endsection
</x-app-layout>
