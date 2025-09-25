<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFault extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom', 'equipment', 'priority', 'description', 'user_id'
    ];

    public function evidences()
    {
        return $this->hasMany(ReportEvidence::class, 'report_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
