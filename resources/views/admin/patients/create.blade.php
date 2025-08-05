<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            {{ __('Thêm bệnh nhân mới') }}
        </h2>
    </x-slot>
@section('content')
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf

                    @include('admin.patients._form')

                    <div class="mt-6 flex justify-between items-center">
    <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-5 py-2 rounded shadow">
        💾 Lưu
    </button>

    <a href="{{ route('admin.patients.index') }}"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow">
        ❌ Huỷ
    </a>
</div>

                </form>
            </div>
        </div>
    </div>
     @endsection
</x-app-layout>


