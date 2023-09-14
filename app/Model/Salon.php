<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
  protected $table = "salon";

  protected $primaryKey = 'idsalon';

  public $timestamps = false;
}