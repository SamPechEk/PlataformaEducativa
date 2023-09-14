<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
  protected $table = "asignatura";

  protected $primaryKey = 'idasignatura';

  public $timestamps = false;
}