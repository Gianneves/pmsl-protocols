<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departaments extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function protocols() {
        return $this->hasMany(Protocols::class);
    }
}
