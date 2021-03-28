<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_hash_id', 'index'];
}
