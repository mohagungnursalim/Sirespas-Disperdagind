<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retribusi extends Model
{
    use HasFactory;
    protected $table = 'retribusis';
    protected $guarded = ['id'];


    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'pasar_id');
    }
}
