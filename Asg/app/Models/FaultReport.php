<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaultReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'classroom_id',
        'equipment_id',
        'description',
        'status',
    ];


    protected $table = 'report_faults';

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function evidences()
    {
        return $this->hasMany(ReportEvidence::class);
    }

        public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}