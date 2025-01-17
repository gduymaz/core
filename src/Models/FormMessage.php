<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormMessage extends BaseModel
{
    use SoftDeletes;

    protected $table = 'form_messages';
    protected $guarded = ['id'];
    protected $casts = ['data' => 'array'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
