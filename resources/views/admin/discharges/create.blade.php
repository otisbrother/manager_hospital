@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Thêm xuất viện</h2>
    <form action="{{ route('admin.discharges.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="patient_id" class="form-label">Bệnh nhân</label>
            <select name="patient_id" class="form-select" required>
                <option value="">-- Chọn bệnh nhân --</option>
                @foreach($patients as $p)
                    <option value="{{ $p->id }}">{{ $p->id }} - {{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="discharge_date" class="form-label">Ngày xuất viện</label>
            <input type="date" name="discharge_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection
