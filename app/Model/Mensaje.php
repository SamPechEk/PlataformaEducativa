<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
  protected $table = "mensaje";

  protected $primaryKey = 'idmensaje';

  public $timestamps = false;
}