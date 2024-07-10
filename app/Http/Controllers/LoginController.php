<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.login');
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
        $data = [
            'name' => $request->fullname,
            'password' => $request->password,
        ];

        // dd($data);

        $user = Auth::attempt($data);

        if (!$user) {
            return redirect()->back('login.index')->with('pesan', 'Email dan Password Salah!!');
        }

        if (Auth::user()->role == 'Admin') {
            return redirect()->route('admin.index')->with('pesan', 'Selamat Datang Admin');
        } elseif (Auth::user()->role == 'Petugas') {
            return redirect()->route('petugas.index')->with('pesan', 'Selamat Datang Petugas');
        } else {
            return redirect()->route('user.index')->with('pesan', 'Selamat Datang User');
        }
    }
    public function storeapi(Request $request)
    {
        $data = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        if (!Auth::attempt($data)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau Password anda Salah!!',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'message' => 'Selamat Datang ' . $user->role,
            'data' => $user,
        ]);
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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.index')->with('pesan', 'Berhasil Logout');
    }
}
