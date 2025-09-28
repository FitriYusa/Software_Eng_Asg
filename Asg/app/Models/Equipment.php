<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id', 
        'name',
        'model', 
        'serialNumber', 
        'installationDate', 
        'lastMaintenanceDate', 
        'status'];


    protected $table = 'equipment';

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function faultReports()
    {
        return $this->hasMany(FaultReport::class);
    }
}
