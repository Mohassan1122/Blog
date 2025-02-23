<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('backend.product.index', compact('products'));
    }

    public function productStatus(Request $request)
    {

        if ($request->mode == 'true') {
            DB::table('products')->where('id', $request->id)->update(['status' => "active"]);
        } else {
            DB::table('products')->where('id', $request->id)->update(['status' => "inactive"]);
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
        return view('backend.product.create');
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
            "summary" => 'string|required',
            "description" => 'string|nullable',
            "stock" => 'nullable|numeric',
            "price" => 'nullable|numeric',
            "discount" => 'nullable|numeric',
            "photo" => 'required',
            "brand_id" => 'nullable|exists:brands,id',
            "cat_id" => 'nullable|exists:categories,id',
            "child_cat_id" => 'nullable|exists:categories,id',
            "size" => 'nullable',
            "condition" => 'nullable',
            "vendor_id" => 'string|nullable',
            "status" => 'nullable|in:active,inactive'

        ]);

        $data = $request->all();

        $slug = Str::slug($request->input('title'));
        $slug_count = Product::where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug .= time() . '-' . $slug;
        }
        $data['slug'] = $slug;

        $data['offer_price'] = ($request->price-(($request->price*$request->discount)/100));
        $status = Product::create($data);
        if ($status) {
            return redirect()->route('product.index')->with('success', 'Successfully Created product');
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
        $product = Product::find($id);
        if ($product) {
            return view('backend.product.edit', compact(['product']));
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
        $product = Product::find($id);

        if ($product) {

            $this->validate($request,  [
                "title" => 'string|required',
                "summary" => 'string|required',
                "description" => 'string|nullable',
                "stock" => 'nullable|numeric',
                "price" => 'nullable|numeric',
                "discount" => 'nullable|numeric',
                "photo" => 'required',
                "brand_id" => 'nullable|exists:brands,id',
                "cat_id" => 'nullable|exists:categories,id',
                "child_cat_id" => 'nullable|exists:categories,id',
                "size" => 'nullable',
                "condition" => 'nullable',
                "vendor_id" => 'string|nullable',
                "status" => 'nullable|in:active,inactive'
            ]);

            $data = $request->all();

            $data['offer_price'] = ($request->price-(($request->price*$request->discount)/100));
            //return $data;
            $status = $product->fill($data)->save();
            if ($status) {
                return redirect()->route('product.index')->with('success', 'Successfully Updated Product');
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
        $product = Product::find($id);

        if ($product) {
            $status = $product->delete();
            if ($status) {
                return redirect()->route('product.index')->with('success', 'Successfully Deleted product');
            } else {
                return redirect()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Data not Found');
        }
    }
}
