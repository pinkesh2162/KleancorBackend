<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Image;

class ImageController extends Controller
{
public function uploadImage(Request $request)
{
    $imageName = '';
    if ($request->file('avatar')) {
        $image = $request->avatar;
        $imageName = $image->getClientOriginalName();
        $image = Image::make($image)->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(storage_path('app/public/images/avatar/' . $imageName), 70);
        $url = URL::to('/') . '/storage/images/avatar/' . $imageName;

        $tableData = [          
            'avatar' => $url,
        ];

        DB::table('users')
            ->where('id', $request->id)
            ->update($tableData);
    }
    return response()->json(['isSuccess' => true, 'url' => $url]);
}



    public function uploadPdf(Request $request){
        $imageName = '';
        if ($request->file('insurance_img')) {
        $imageName = $request->insurance_img->getClientOriginalName();
        $request->insurance_img->storeAs('public/images/insurance', $imageName);
        $url = URL::to('/') . '/storage/images/insurance/' . $imageName;

        $tableData = [          
            'insurance_img' => $url,
        ];

        DB::table('users')
            ->where('id', $request->id)
            ->update($tableData);
        }
        return response()->json(['isSuccess' => true, 'url' => $url]);
     
    }
}