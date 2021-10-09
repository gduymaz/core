<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BaseModel
{
    use SoftDeletes;

    protected $table = 'menu_item_translations';
    protected $guarded = ['id'];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}
