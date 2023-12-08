<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;
    protected $table = 'faktur';
    protected $guarded = ['id'];

    public function relasi_pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, "pelanggan_id", 'id');
    }
}
