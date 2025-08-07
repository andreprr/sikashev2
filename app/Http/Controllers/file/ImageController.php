<?php

namespace App\Http\Controllers\file;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function storeimage(Request $request, $category)
    {

        if($request->imgfile){
            
            $request->validate([
                'imgfile' => 'required|mimes:jpg,png|max:8192',
            ]);

            $fileName = $category.time().'.'.$request->imgfile->extension();

            $request->imgfile->move(storage_path('app/cloudfolder/images'), $fileName);

            $data['file_name'] = $fileName;
            $data['file_url'] = route('getimage',$fileName);
            $data['message'] = 'success';

            return jsend_success($data);
        }
        
        return jsend_error(['errorr' => 'Someting Wrong!']);
    }

    public function getimage($file){
        $path = storage_path('app/cloudfolder/images/'.$file);

        if (file_exists($path)) {

            return response()->file($path, array('Content-Type' =>'image/jpeg'));

        }

        abort(404);
    }

    public function getpdf($file){
        $path = storage_path('app/cloudfolder/pdf/'.$file);

        if (file_exists($path)) {

            return response()->file($path, array('Content-Type' =>'application/pdf'));

        }

        abort(404);
    }
}
