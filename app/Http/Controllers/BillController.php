<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Patient;
use App\Services\BillCalculationService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::query();
        
        // Tìm kiếm tổng hợp
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('patient_id', 'like', '%' . $search . '%')
                  ->orWhere('prescription_id', 'like', '%' . $search . '%')
                  ->orWhere('health_insurance_id', 'like', '%' . $search . '%');
            });
        }
        
        // Tìm kiếm theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Sắp xếp theo ngày tạo mới nhất
        $query->orderBy('created_at', 'desc');
        
        $bills = $query->paginate(15);
        
        return view('admin.bills.index', compact('bills'));
    }

    public function create()
    {
        return view('admin.bills.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string|max:15',
            'health_insurance_id' => 'nullable|string|max:15',
            'patient_id' => 'required|string|max:10',
            'prescription_id' => 'nullable|string|max:10',
            'total' => 'nullable|numeric|min:0',
        ]);

        // Nếu có prescription_id, tính toán lại tổng tiền với bảo hiểm
        if (!empty($validated['prescription_id'])) {
            $patient = Patient::find($validated['patient_id']);
            if ($patient) {
                $billCalculationService = new BillCalculationService();
                
                // Tính tổng tiền gốc từ prescription
                $totalAmount = 0;
                // TODO: Lấy thông tin prescription và tính toán
                
                $calculation = $billCalculationService->calculateBillWithInsurance($totalAmount, $patient);
                $validated['total'] = $calculation['patient_amount'];
                $validated['health_insurance_id'] = $calculation['insurance_id'];
            }
        }

        Bill::create($validated);
        return redirect()->route('admin.bills.index')->with('success', 'Thêm hóa đơn thành công');
    }

    public function edit($id)
    {
        $bill = Bill::findOrFail($id);
        return view('admin.bills.edit', compact('bill'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'health_insurance_id' => 'nullable|string|max:15',
            'patient_id' => 'required|string|max:10',
            'prescription_id' => 'nullable|string|max:10',
            'total' => 'nullable|numeric|min:0',
        ]);

        $bill = Bill::findOrFail($id);
        $bill->update($validated);
        return redirect()->route('admin.bills.index')->with('success', 'Cập nhật hóa đơn thành công');
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        return redirect()->route('admin.bills.index')->with('success', 'Xóa hóa đơn thành công');
    }
}