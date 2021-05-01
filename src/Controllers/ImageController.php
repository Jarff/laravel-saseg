<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index(){
        $info = [
            'title' => 'Categorías',
            'breadcrumb' => [
                [
                    'title' => 'Todos',
                    'route' => 'panel.categories.index',
                ]
            ]
        ];
        $info['data'] = $this->formatFiles(Storage::files('public/media'));
        return view('panel.images.index', $info);
    }

    public function store(Request $request){
        $path_file = $request->file('file')->store('public/media');
        $info['size'] = Storage::size($path_file);
        $info['type'] = Storage::getMimeType($path_file);
        $_exploded = explode('/', $path_file);
        $_exploded[0] = 'storage';
        $path_file = implode('/', $_exploded);
        $info['file_name'] = $path_file;
        $info['url'] = asset($path_file);
        $info['success'] = true;
        return response($info);
    }

    public function storeMultiple(Request $request){
        $infos = [];
        foreach ($request->file('file') as $key => $file) {
            $path_file = $file->store('public/media');
            $info['size'] = Storage::size($path_file);
            $info['type'] = Storage::getMimeType($path_file);
            $_exploded = explode('/', $path_file);
            $_exploded[0] = 'storage';
            $path_file = implode('/', $_exploded);
            $info['file_name'] = $path_file;
            $info['url'] = asset($path_file);
            $info['success'] = true;
            $infos[] = $info;
        }
        return response($infos);
    }

    public function show(){
        $files = $this->formatFiles(Storage::files('public/media'));
        return response()->json(['success' => true, 'files' => array_values($files)]);
    }

    public function formatFiles($files){
        foreach($files as $i => $file){
            $_exploded = explode('/', $file);
            if(end($_exploded) != '.DS_Store'){
                $info['size'] = Storage::size($file);
                $info['name'] = end($_exploded);
                $info['type'] = Storage::getMimeType($file);
                $info['url'] = asset('storage/media/'.end($_exploded));
                $info['path'] = 'storage/media/'.end($_exploded);
                $info['last_modified'] = date('d-m-Y', Storage::lastModified($file));
                $files[$i] = $info;
            }else{
                unset($files[$i]);
            }       
        }
        return $files;
    }

    public function destroy($file_path){
        if(Storage::get('public/media/'.$file_path)){
            Storage::delete('public/media/'.$file_path);
            return response(['success' => true], 200);
        }else{
            return response(['success' => false], 200);
        }
    }
}
