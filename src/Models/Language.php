<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    public $timestamps = false;

    protected $guarded = ['id'];
}
