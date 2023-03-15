<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        $image = $request->file('image');
        if ($image) {

            $imageName = uniqid() . '.' . $image->extension();
            $image->move('images-upload', $imageName);

            return response()->json([
                'message' => 'Image successfully uploaded!',
                'data' => [
                    'name' => $imageName,
                    'url' => asset('images-upload/' . $imageName)
                ]
            ]);
        } else {
            return response()->json([
                'message' => 'Image failed upload!',
            ], 422);
        }
    }
}
