<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\GmailRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // logic login
    // $request contains all input from ajax
    public function store(Request $request)
	{
        // validation for all inputs that have a attribute name
		$validator = Validator::make($request->all(), [
            // input name email must follow the following rules
            // new GmailRule means initialize gmailrule.php then call gmailrule then have to use gmail
			'email' => ['required', new GmailRule, 'email'],
			'password' => ['required', 'min:6', 'max:20']
		]);

        // if normal validation fails
		if ($validator->fails()) {
            // return response as json to javascript
			return response()->json([
                // status key contains value 0
				'status' => 0,
				'message' => 'Normal validation encountered an error.',
                // erros will contains all error attribute name values and their error message
				'errors' => $validator->errors()
			]);
		};

        // if the validation is passes then check whether the email and password entered are in the database
        // the seccond argument attempt means remember me feature is true by default
		if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {

            // get user details
            // user variabel contains user table where email column is equal to email` input, get first child
			$user = User::where('email', $request->email)->first();
            // create token to login
            $token = $user->createToken('auth_token')->plainTextToken;

            // return response as json
			return response()->json([
                // status key contains value 200
				'status' => 200,
                // message key contains the following message
				'message' => 'User Berhasil Login',
                // send user details and token
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
			]);
		}


        // // do a repat of all users
        // // each user will be $detail_user
        // foreach(User::all() as $detail_user) {
        //     // if the email input entered is not same as user detail, email
        //     if ($detail_user->email !== $request->email) {
        //         return response()->json([
        //             'message' => 'This email is not registered yet'
        //         ]);
        //     };
        // };

        // get user detail
        $user_detail = User::where('email', $request->email)->first();

        // if email is not registered
        // return response as json
        if (!$user_detail) {
            return response()->json([
                'message' => 'Email has not been registered'
            ]);
        }

        // if the password is wrong
        // return response as json
        return response()->json([
            'status' => 0,
            'message' => 'the password is wrong'
        ]);
	}

    public function logout()
    {

    }
}
