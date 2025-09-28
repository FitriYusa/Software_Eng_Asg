<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaultReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'classroom_id',
        'equipment_id',
        'assigned_to',
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
        return $this->hasMany(ReportEvidence::class, 'report_id','id');
    }

        public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'users_id');
}



}