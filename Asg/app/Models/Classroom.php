<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    protected $appends = ['name']; // so it's included in JSON/arrays

    public function getNameAttribute()
    {
        return "{$this->building} {$this->floor}-{$this->roomNumber}";
    }
}
