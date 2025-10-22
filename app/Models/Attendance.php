<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;
    protected $fillable = ['student_id', 'date', 'status', 'remarks','is_holiday'];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function holidays() {
        return $this->hasMany(Holiday::class);
    }
}
