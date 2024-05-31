<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retribusi extends Model
{
    use HasFactory;
    protected $table = 'retribusis';
    protected $guarded = ['id'];


    public function users()
    {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function pasars()
    {
      return $this->belongsTo(User::class, 'pasar_id');
    }
}
