<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
  protected $table = "periodo";

  protected $primaryKey = 'idperiodo';

  public $timestamps = false;
}