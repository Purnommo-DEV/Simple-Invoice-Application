<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturBarang extends Model
{
    use HasFactory;
    protected $table = 'faktur_barang';
    protected $guarded = ['id'];
}
