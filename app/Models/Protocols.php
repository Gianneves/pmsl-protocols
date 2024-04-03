<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocols extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'person_id', 'created_data', 'deadline',];

    public function person() {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
