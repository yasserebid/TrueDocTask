<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['first_name','second_name','family_name','uid'];
    public $timestamps = true;
}
