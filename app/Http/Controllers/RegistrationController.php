<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// gunakan model user
use App\Models\User;
// menambahkan validasi baru yaitu harus berformat gmail
use App\Rules\GmailRule;
// agar password di hash secara acak
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    // $request berisi data-data formulir atau value input attribute name="" yang dikirim oleh script
    public function store(Request $request)
    {
        // validasi untuk semua input yang punya attribute name
		$validator = Validator::make($request->all(), [
            // value input name="name" harus mengikut aturan berikut
            'name' => ['required', 'unique:users', 'string', 'min:3', 'max:50'],
            // unique berarti tidak boleh sama
            // new GmailRule berarti user hanya boleh memasukkan akun gmail
            'email' => ['required', new GmailRule, 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'min:6', 'max:20']
		]);

		// jika validasi biasa gagal
		if ($validator->fails()) {
            // kembalikkan tanggapan berupa json yang berisi array assosiatif ke javascript
			return response()->json([
                // key status berisi value 0
				'status' => 0,
                // key message berisi pesan 'Validasi Biasa Errors'
				'message' => 'Validasi Biasa Errors',
				// errors akan berisi semua value attribute name yang error dan pesan errornya
				'errors' => $validator->errors()
			]);
		};


        // simpan user
        // user::buat([])
        $user = User::create([
            // column nama berisi value input name="nama"
            'name' => $request->name,
            // column email berisi value input name="email"
            'email' => $request->email,
            // column password berisi value input name="password" yang sudah di hash
            // hash::buat
            'password' => Hash::make($request->password),
        ]);

        // create token to login
        $token = $user->createToken('auth_token')->plainTextToken;

        // after the data has been successfully saved to the database
        // return response as json then send data
        return response()->json([
            // key status contains value 200
            'status' => 200,
            // the message key contains the following value
            'message' => 'Berhasil Registrasi, silahkan login',
            'token' => $token,
            'user' => $user
        ]);
    }
}
