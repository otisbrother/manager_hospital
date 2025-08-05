<?php

namespace App\Http\Controllers;

use App\Models\DetailPrescription;
use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;

class DetailPrescriptionController extends Controller
{
    public function index()
    {
        $details = DetailPrescription::with(['prescription', 'medicine'])->get();
        return view('admin.detail_prescriptions.index', compact('details'));
    }

    public function create()
    {
        $prescriptions = Prescription::all();
        $medicines = Medicine::all();
        return view('admin.detail_prescriptions.create', compact('prescriptions', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prescription_id' => 'required|exists:prescriptions,id',
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DetailPrescription::create($request->all());

        return redirect()->route('admin.detail-prescriptions.index')->with('success', 'Thêm chi tiết đơn thuốc thành công.');
    }

    public function edit($prescription_id, $medicine_id)
    {
        $detail = DetailPrescription::where('prescription_id', $prescription_id)
                                    ->where('medicine_id', $medicine_id)
                                    ->firstOrFail();

        $prescriptions = Prescription::all();
        $medicines = Medicine::all();

        return view('admin.detail_prescriptions.edit', compact('detail', 'prescriptions', 'medicines'));
    }

    public function update(Request $request, $prescription_id, $medicine_id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $detail = DetailPrescription::where('prescription_id', $prescription_id)
                                    ->where('medicine_id', $medicine_id)
                                    ->firstOrFail();

        $detail->update(['quantity' => $request->quantity]);

        return redirect()->route('admin.detail-prescriptions.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy($prescription_id, $medicine_id)
    {
        DetailPrescription::where('prescription_id', $prescription_id)
                          ->where('medicine_id', $medicine_id)
                          ->delete();

        return redirect()->route('admin.detail-prescriptions.index')->with('success', 'Đã xoá chi tiết đơn thuốc.');
    }
}
