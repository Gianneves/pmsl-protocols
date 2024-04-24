<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocols extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'created_data', 'deadline', 'person_id', 'departament_id', 'files'];

    public function person() {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function departaments() {
        return $this->belongsTo(Departaments::class, 'departament_id');
    }

    public function attendances() {
        return $this->hasMany(Attendance::class, 'protocol_id');
    }

    public function latestAttendanceSituation() {
        return $this->attendances()->latest()->value('situation');
    }
}
