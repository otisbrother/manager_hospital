<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
            {{ __('Chỉnh sửa bệnh nhân') }}
        </h2>
    </x-slot>
    @section('content')
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.patients._form')

                </form>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>


