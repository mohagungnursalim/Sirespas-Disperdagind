<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    use HasFactory;

    protected $table = 'pasars';
    protected $guarded = ['id'];

    public function retribusi()
    {
        return $this->belongsTo(Retribusi::class, 'retribusi_id');
    }
    
}
