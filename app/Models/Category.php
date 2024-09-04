<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'photo',
        'is_parent',
        'parent_id',
        'status'
    ];

    public static function shiftChild($cart_id)
    {
        return Category::whereIn("id", $cart_id)->update(['is_parent'=>1]);
    }

    public static function getChildByParentId($id)
    {
        return Category::where("parent_id", $id)->pluck('title', 'id');
    }
    public function products()
    {
       return $this->HasMany('App\Models\Product', 'cat_id', 'id');
    }
}
