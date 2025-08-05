@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Chỉnh sửa thông tin xuất viện</h2>

    <form action="{{ route('admin.discharges.update', [$discharge->patient_id, $discharge->discharge_date->format('Y-m-d')]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Bệnh nhân --}}
        <div class="mb-3">
            <label for="patient_id" class="form-label">Bệnh nhân</label>
            <select name="patient_id" id="patient_id" class="form-select" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}"
                        {{ $patient->id == $discharge->patient_id ? 'selected' : '' }}>
                        {{ $patient->id }} - {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Ngày xuất viện --}}
        <div class="mb-3">
            <label for="discharge_date" class="form-label">Ngày xuất viện</label>
            <input type="date" name="discharge_date" id="discharge_date"
                   class="form-control"
                   value="{{ $discharge->discharge_date->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.discharges.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
