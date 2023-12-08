<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghitung extends Model
{
    use HasFactory;
    protected $table = 'penghitung';
    protected $guarded = ['id'];
}
