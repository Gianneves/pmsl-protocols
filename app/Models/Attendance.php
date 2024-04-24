<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['protocol_id','description', 'situation'];

    public function protocol() {
        return $this->belongsTo(Protocols::class, 'protocol_id');
    }
}
