<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportEvidence extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'file_path', 
        'file_type', 
        'description'
    ];

    public function fault()
    {
        return $this->belongsTo(FaultReport::class, 'report_id', 'id');
    }
}
