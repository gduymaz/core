<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslation extends BaseModel
{
    use SoftDeletes;

    protected $table = 'category_translations';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function extras()
    {
        return $this->hasMany(CategoryTranslationExtra::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function url()
    {
        return $this->morphOne(Url::class, 'model');
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if (method_exists($this, 'extras')) {
            $extras = $this->extras()->where('key', $key)->get();
            if ($extras->isNotEmpty()) {
                if ($extras->count() > 1) {
                    return $extras->pluck("value")->toArray();
                } else {
                    return $extras->first()->value;
                }
            }
        }

        if(\Str::startsWith($key, 'mf_')) {
            $key = mb_substr($key, 3);
            $medias = $this->medias();
            if($key) {
                $medias->wherePivot('key', $key);
            }
            return $medias->orderBy('model_medias.order')->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $key = mb_substr($key, 3);
            $medias = $this->medias();
            if($key) {
                $medias->wherePivot('key', $key);
            }
            return $medias->orderBy('model_medias.order')->get();
        }

        return $attribute;
    }
}
