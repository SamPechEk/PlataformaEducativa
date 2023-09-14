<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Maestro extends Model
{
  protected $table = "maestro";

  protected $primaryKey = 'idmaestro';

  public $timestamps = false;
}