<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_hash_id', 'index'];

  /**
   * @param $hashed_file
   */
  public static function saveHash($hashed_file)
  {
    self::create([
      'file_hash_id' => $hashed_file
    ]);
  }

  /**
   * @param $hash_id
   * @return mixed
   */
  public static function fetchHash($hash_id)
  {
    return Self::where('file_hash_id', $hash_id)->first();
  }
}
