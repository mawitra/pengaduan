<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = DB::table('users')->wherein('role', ['Admin', 'Petugas'])->get();
        return view('admin.akun.index', compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.akun.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->nik = $request->input('fullname');
        $user->no_telp = '';
        $user->save();

        return redirect()->route('akun.index')->with('pesan', 'Behasil di Tambahkan');
    }

    public function storeapi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'fullname' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $translatedErrors = [];

            foreach ($errors as $field => $messages) {
                foreach ($messages as $message) {
                    switch ($message) {

                        case 'The email has already been taken.':
                            $translatedErrors[$field][] = 'Email sudah digunakan.';
                            break;

                        case 'The email must be a valid email address.':
                            $translatedErrors[$field][] = 'Email harus alamat email yang valid.';
                            break;
                        case 'The password must be at least 8 characters.':
                            $translatedErrors[$field][] = 'Kata sandi harus terdiri dari minimal 8 karakter.';
                            break;
                        default:
                            $translatedErrors[$field][] = $message;
                            break;
                    }
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal Registrasi',
                'errors' => $translatedErrors
            ], 402);
        }


        // Create a new user
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = 'User';
        $user->fullname = $request->input('fullname');
        $user->no_telp = '';
        $user->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'User successfully registered',
            'data' => $user
        ], 200);
    }


    public function register(Request $request)
    {

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->nik = $request->input('nik');
        $user->no_telp = $request->input('no_telp');
        $user->save();

        return redirect()->route('login.index')->with('pesan', 'Behasil di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        $user = DB::table('users')->where('role', 'User')->get();

        return view('admin.akun.user', compact('user'));
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

        return view('admin.akun.edit', compact('user'));
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
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->nik = '';
        $user->no_telp = '';
        $user->update();

        return redirect()->route('akun.index')->with('pesan', 'Behasil di Tambahkan');
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
        $user->delete();

        return redirect()->route('akun.index')->with('pesan', 'Data Berhasil di Hapus!!');
    }
}
