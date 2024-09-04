<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('backend.category.index', compact('categories'));
    }

    public function categoryStatus(Request $request)
    {

        if ($request->mode == 'true') {
            DB::table('categories')->where('id', $request->id)->update(['status' => "active"]);
        } else {
            DB::table('categories')->where('id', $request->id)->update(['status' => "inactive"]);
        }
        return response()->json(['msg' => 'Status updated Successfully', 'status' => 'true']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_carts = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        return view('backend.category.create', compact('parent_carts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,  [
            "title" => 'string|required',
            "summary" => 'string|nullable',
            "is_parent" => 'sometimes|in:1',
            "parent_id" => 'nullable|exists:categories,id',
            "status" => 'nullable|in:active,inactive'
        ]);

        //dd($request->all());
        $data = $request->all();
        $data['is_parent'] = $request->input('is_parent', 0);

        $slug = Str::slug($request->input('title'));
        $slug_count = Category::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug .= time() . '-' . $slug;
        }
        $data['slug'] = $slug;
        //dd($data['is_parent']);
        $status = Category::create($data);
        if ($status) {
            return redirect()->route('category.index')->with('success', 'Successfully Created category');
        } else {
            return redirect()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $parent_carts = Category::where('is_parent', 1)->orderBy('title', 'ASC')->get();
        if ($category) {
            return view('backend.category.edit', compact(['category', 'parent_carts']));
        } else {
            return back()->with('error', 'Data not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $category = Category::find($id);

        if ($category) {

            $this->validate($request,  [
                "title" => 'string|required',
                "summary" => 'string|nullable',
                "is_parent" => 'sometimes|in:1',
                "parent_id" => 'nullable|exists:categories,id'
            ]);

            $data = $request->all();


            if ($request->is_parent == 1) {
                $data['parent_id'] = null;
            }
            $data['is_parent'] = $request->input('is_parent', 0);
            $status = $category->fill($data)->save();
            if ($status) {
                return redirect()->route('category.index')->with('success', 'Successfully Updated category');
            } else {
                return redirect()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Data not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $child_cart_id = Category::where('parent_id', $id)->pluck('id');
        if ($category) {
            $status = $category->delete();
            if ($status) {

                if (count($child_cart_id) > 0) {
                    Category::shiftChild($child_cart_id);
                }

                return redirect()->route('category.index')->with('success', 'Successfully Deleted category');
            } else {
                return redirect()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Data not Found');
        }
    }

    public function getChildByParentId(Request $request, $id)
    {
        $category = Category::find($request->id);
        //dd($category);
        if ($category) {


            $child_id = Category::getChildByParentId($request->$id);
          

            if (count($child_id) <= 0) {
                return response()->json(['status'=>false, 'data'=>null, 'msg' => 'fail1']);
            }
            return response()->json(['status'=>true, 'data'=>$child_id, 'msg' => 'pass']);
        } else {
            return response()->json(['status'=>false, 'data'=>null, 'msg' => 'fail2']);
        }
    }
}
