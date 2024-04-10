<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocols extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'created_data', 'deadline', 'person_id', 'files'];

    public function person() {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
