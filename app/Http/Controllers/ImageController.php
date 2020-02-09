<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    //

    public function upload(Request $request)
    {

        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
            
        $imageName = time()."_".$request->image->getClientOriginalName(); // getting the original name of the image
        $request->image->move(public_path('images/uploads'), $imageName);
    }
}
