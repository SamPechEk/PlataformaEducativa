<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Disputa extends Model
{
  protected $table = "disputa";

  protected $primaryKey = 'iddisputa';

  public $timestamps = false;
}