<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    /** @use HasFactory<\Database\Factories\LeaveRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from_date',
        'to_date',
        'reason_type',
        'reason',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
