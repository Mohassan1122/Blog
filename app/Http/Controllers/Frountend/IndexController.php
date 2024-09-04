<?php

namespace App\Http\Controllers\Frountend;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class IndexController extends Controller
{
    public function home()
    {
        $banners = Banner::where(['status'=>'active', 'condition'=>'banner'])->orderBy('id', 'DESC')->limit(5)->get();
        $categories = Category::where(['status'=>'active', 'is_parent'=>1])->orderBy('id', 'DESC')->limit(3)->get();
        return view("frontend/index", compact('banners','categories'));
    }
    public function productCategory($slug)
    {
        $category = Category::with('products')->where('slug', $slug)->first();
        return view('frontend.pages.productCategory', compact(['category']));
    }
}
