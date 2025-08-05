<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'insurance_id',
        'support_level',
        'status',
        'proof_images',
        'admin_notes',
        'approved_by',
        'approved_at',
        'admin_notified',
    ];

    protected $casts = [
        'proof_images' => 'array',
        'approved_at' => 'datetime',
    ];

    // Quan hệ với bệnh nhân
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Quan hệ với bảo hiểm y tế
    public function healthInsurance()
    {
        return $this->belongsTo(HealthInsurance::class, 'insurance_id');
    }

    // Quan hệ với admin duyệt
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scope cho trạng thái
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helper methods
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => '⏳ Chờ duyệt',
            'approved' => '✅ Đã duyệt bởi admin',
            'rejected' => '❌ Bị từ chối',
            default => 'Không xác định'
        };
    }

    public function getSupportLevelTextAttribute()
    {
        return match($this->support_level) {
            '80' => '80% chi phí (Nhóm phổ thông)',
            '95' => '95% chi phí (Hộ cận nghèo)',
            '100' => '100% chi phí (Hộ nghèo, người có công)',
            default => 'Không xác định'
        };
    }

    public function requiresProofImages()
    {
        return in_array($this->support_level, ['95', '100']);
    }
} 