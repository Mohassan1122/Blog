<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('backend.user.index', compact('users'));
    }

    public function userStatus(Request $request)
    {

        if ($request->mode == 'true') {
            DB::table('users')->where('id', $request->id)->update(['status' => "active"]);
        } else {
            DB::table('users')->where('id', $request->id)->update(['status' => "inactive"]);
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
        return view('backend.user.create');
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
            "fullname" => 'string|required',
            "username" => 'string|nullable',
            "email" => 'string|required|unique:users,email',
            "password" => 'min:4|required',
            "phone" => 'nullable|string',
            "photo" => 'required',
            "address" => 'nullable|string',
            "role" => 'required|in:admin,customer,vendor',
            "status" => 'nullable|in:active,inactive'

        ]);

        $data = $request->all();

        $data['password'] = Hash::make($request->password) ;


        $status = User::create($data);
        if ($status) {
            return redirect()->route('user.index')->with('success', 'Successfully Created user');
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
        $user = User::find($id);
        if ($user) {
            return view('backend.user.edit', compact(['user']));
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
        //return $request->all();
        $product = User::find($id);

        if ($product) {

            $this->validate($request,  [
                "fullname" => 'string|required',
                "username" => 'string|nullable',
                "email" => 'string|required|exists:users,email',
                "phone" => 'nullable|string',
                "photo" => 'required',
                "address" => 'nullable|string',
                "role" => 'required|in:admin,customer,vendor',
                "status" => 'nullable|in:active,inactive'
            ]);

            $data = $request->all();


           // return $data;
            $status = $product->fill($data)->save();
            if ($status) {
                return redirect()->route('user.index')->with('success', 'Successfully Updated User');
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
        $user = User::find($id);

        if ($user) {
            $status = $user->delete();
            if ($status) {
                return redirect()->route('user.index')->with('success', 'Successfully Deleted user');
            } else {
                return redirect()->with('error', 'Something went wrong');
            }
        } else {
            return back()->with('error', 'Data not Found');
        }
    }
}
