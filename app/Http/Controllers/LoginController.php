<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dotenv\Exception\ValidationException;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
    }

    public function login(Request $request)
    {

        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);



        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();
            $user->activities()->create([
                'action' => "Login"
            ]);


            return response()->json($user, 200);
        }
        // throw ValidationException::withMessages([
        //     'email' => ['The provided credentials are incorrect']
        // ]);
        return response()->json([
            'message' => 'Record not found.'
        ], 404);
    }

    public function logout()
    {
        $user = Auth::user();
        // $response['user_id'] = $user->id;

        if ($user) {
            $user->activities()->create([
                'action' => "Logout"
            ]);

            Auth::logout();
        }

        // return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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