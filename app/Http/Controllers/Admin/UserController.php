<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }


    public function getUserList(Request $request)
    {

        $response = [];

        $users_query = User::orderBy('is_admin', 'DESC')->orderBy('updated_at', 'DESC');
        if ($request->username) {
            $users_query = $users_query->where('username', 'LIKE', '%' . $request->username . '%');
        }

        if ($request->name) {
            $users_query = $users_query->where('name', 'LIKE', '%' . $request->name . '%');
        }

        if ($request->email) {
            $users_query = $users_query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        if ($request->isAdmin && $request->isAdmin === 'true') {
            $users_query = $users_query->where('is_admin', true);
        }



        $response['users'] = $users_query->get();



        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $response['req']   = $request->isAdmin;
        // return $request;
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'isAdmin' => ['required'],
        ]);

        if ($validator->fails()) {
            $response['errors']   = $validator->getMessageBag()->toArray();
            return $response;
        }
        // $request->validate([
        //     'name' => ['required'],
        //     'username' => ['required', 'unique:users'],
        //     'password' => ['required', 'min:1'],
        //     'isAdmin' => ['required'],
        // ]);





        $new_user =  User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_admin' => $request->isAdmin,
            'email' => $request->email,
        ]);



        $response['new_user'] = $new_user;



        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $response['user'] = $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $response['user'] = $user;

        return $response;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}