<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    // protected $guarded = ['id'];
    protected $guarded = ['id'];
    
    public function komoditas()
    {
        return $this->belongsTo(Komoditas::class);
    }

    public function pangans()
    {
        return $this->hasMany(Pangan::class);
    }
}
