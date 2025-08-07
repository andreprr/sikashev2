<?php

namespace App\Http\Controllers\file;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Illuminate\Support\Facades\Response;

class FileManagerController extends Controller
{

    public function upload(Request $request)
    {
        if($request->formFile && $request->uploadtype == 'image'){
            $request->validate([
                'formFile' => 'required|mimes:jpg,png|max:4000',
            ]);
            
            $fileName = Auth::user()->id.'_16_'.time().'.'.$request->formFile->extension();
            $location = 'app/cloudfolder/files/'.Auth::user()->id.'/image'.'/';
            $request->formFile->move(storage_path($location), $fileName);

            $data['file_url'] = route('getfilefm',$fileName);

            return jsend_success($data);
        }

        if($request->formFile && $request->uploadtype == 'audio'){
            $request->validate([
                'formFile' => 'required|mimes:audio/mpeg,mpga,mp3,wav,aac|max:10000',
            ]);

            $fileName = Auth::user()->id.'_44_'.time().'.'.$request->formFile->extension();
            $location = 'app/cloudfolder/files/'.Auth::user()->id.'/audio'.'/';
            $request->formFile->move(storage_path($location), $fileName);

            $data['file_url'] = route('getfilefm',$fileName);

            return jsend_success($data);
        }

        return jsend_error(['errorr' => 'Someting Wrong!']);
    }

    public function getfmdata(Request $request)
    {
        $location = 'app/cloudfolder/files/'.Auth::user()->id.'/'.$request->type;
        $data = collect(File::allFiles(storage_path($location)))
        ->sortByDesc(function ($file) {
            return $file->getCTime();
        })->values()
        ->map(function ($file) {
            return route('getfilefm',$file->getBaseName());
        });

        return jsend_success($data);
    }

    public function getfilefm($file){
        if($file){
            $ex = explode('_',$file);
            $location = 'app/cloudfolder/files/'.$ex[0].'/'.($ex[1] == 16 ? 'image' : 'audio').'/'.$file;

            $path = storage_path($location);

            if (file_exists($path)) {

                if($ex[1] == 16){
                    return response()->file($path, array('Content-Type' =>'image/jpeg'));
                }else{
                    
                    return response()->file($path, array('Content-Type' =>'audio/mp3'));
                }


            }
        }

        abort(404);
    }

    public function getsectionfile($file){
        if($file){
            $location = 'app/cloudfolder/files/section/'.$file;
            $path = storage_path($location);

            if (file_exists($path)) {
                return response()->file($path);
            }
        }
        abort(404);
    }

    public function getfilemp3($file){
        if($file){
            $ex = explode('_',$file);
            $location = 'app/cloudfolder/files/'.$ex[0].'/'.($ex[1] == 16 ? 'image' : 'audio').'/'.$file;

            $path = storage_path($location);

            if (file_exists($path)) {

                if($ex[1] == 16){
                    return response()->file($path, array('Content-Type' =>'image/jpeg'));
                }else{

                    return response()->file($path, array('Content-Type' =>'audio/mp3'));
                }
            }
        }

        abort(404);
    }

    public function getfile($file){
        $path = storage_path('app/cloudfolder/files/'.$file);

        if (file_exists($path)) {

            return response()->file($path);

        }

        abort(404);
    }
}
