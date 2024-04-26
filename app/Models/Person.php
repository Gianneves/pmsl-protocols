<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Person extends Model implements Auditable
{
    use HasFactory , \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'birthdate', 'cpf', 'gender', 'city', 'district', 'street', 'number', 'complement'];

    public function protocols() {
        return $this->hasMany(Protocols::class);
    }
}
