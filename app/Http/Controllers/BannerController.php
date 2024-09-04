<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'DESC')->get();
        return view('backend.banner.index', compact('banners'));
    }

    public function bannerStatus(Request $request)
    {

        if ($request->mode == 'true') {
            DB::table('banners')->where('id', $request->id)->update(['status' => "active"]);
        } else {
            DB::table('banners')->where('id', $request->id)->update(['status' => "inactive"]);
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
        //
        return view('backend.banner.create');
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
            "slug" => 'string|required|unique:banners,slug',
            "photo" => 'nullable',
            "description" => 'string|nullable',
            "status" => 'nullable|in:active,inactive',
            "condition" => 'nullable|in:banner,promo'
        ]);
        $data = $request->all();

        //return $data;
        $status = Banner::create($data);
        if ($status) {
            return redirect()->route('banner.index')->with('success', 'Successfully Created banner');
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
        $banner = Banner::find($id);

        if ($banner) {
            return view('backend.banner.edit', compact('banner'));
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
        $banner = Banner::find($id);

        if ($banner) {

            $this->validate($request,  [
                "title" => 'string|required',
                "slug" => 'string|required|exists:banners,slug',
                "photo" => 'required',
                "description" => 'string|nullable',
                "status" => 'nullable|in:active,inactive',
                "condition" => 'nullable|in:banner,promo'
            ]);
            $data = $request->all();

            $status = $banner->fill($data)->save();
            if ($status) {
                return redirect()->route('banner.index')->with('success', 'Successfully Updated banner');
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

        $banner = Banner::find($id);

        if ($banner) {
            $status = $banner->delete();
            if ($status) {
                return redirect()->route('banner.index')->with('success', 'Successfully Deleted banner');
            } else {
                return redirect()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Data not Found');
        }
    }
}
