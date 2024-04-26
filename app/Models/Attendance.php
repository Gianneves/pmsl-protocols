<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Attendance extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['protocol_id','description', 'situation'];

    public function protocol() {
        return $this->belongsTo(Protocols::class, 'protocol_id');
    }
}
