<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Person extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'birthdate', 'cpf', 'gender', 'city', 'district', 'street', 'number', 'complement'];

    public function protocols() {
        return $this->hasMany(Protocols::class);
    }
}
