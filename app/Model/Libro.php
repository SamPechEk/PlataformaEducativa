<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
  protected $table = "libro";

  protected $primaryKey = 'idlibro';

  public $timestamps = false;
}