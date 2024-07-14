<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Tutorial;
use Illuminate\Support\Facades\Storage;

class TutorialController extends Controller
{
    public function store(Request $request)
    {
        $user_id = Auth::user()->user_id;


        // validation
        // create validaton for all inputs that have a name attribute
        $validator = Validator::make($request->all(), [
            //
            'name' => 'required|unique:tutorial|min:2|max:20',
            'number_of_meetings' => '',
            'price' => 'required',
            'date' => 'required',
            'time' => 'required',
            'place' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        // if validation fails because the user has entered the data incorrectly
        if ($validator->fails()) {
            // return response as a json
            return response()->json([
                // key status contains value 0
                'status' => 0,
                'pesan' => 'Error',
                // The errors key contains all error attribute name values and all error messages.
                'errors' => $validator->errors()
            ]);
        // else if validation is successful
        } else {

            // upload image
            // rename image
            $nama_image_baru = time() . '_' .  '.' . $request->file('image')->getClientOriginalExtension();
            // The first argument in putFileAs is the place or folder where the image will be saved.
            // the second argument is input name="image"
            // the third argument is the name of the image file
            Storage::putFileAs('public/foto_profil/', $request->file('image'), $nama_image_baru);

            // save tutorial data
            Tutorial::create([
                'user_id' => $user_id,
                // call the name column of the tutorial table filled with the attribute value name="name"
                'name' => $request->name,
                'number_of_meetings' => $request->number_of_meetings,
                'price' => $request->price,
                'date' => $request->date,
                'time' => $request->time,
                'place' => $request->place,
                'description' => $request->description,
                'image' => $nama_image_baru
            ]);

            // return response as a json
            return response()->json([
                'status' => 200,
                'message' => 'successfully added tutorial'
            ]);
        }
        // save tutorial datq
        // return response as a json
    }
}
