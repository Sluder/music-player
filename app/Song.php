<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $timestamps = true;

    protected $fillable = ['name', 'filename', 'length'];
}
