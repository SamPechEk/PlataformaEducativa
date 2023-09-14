<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Momento extends Model
{
  protected $table = "momento";

  protected $primaryKey = 'idmomento';

  public $timestamps = false;
}