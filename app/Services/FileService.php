<?php

namespace App\Services;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class FileService
{
    public function updateFile($model, $request, $type)
    {
        $manager = new ImageManager(new Driver());
        if(!empty($model->file)){
            $currentFile = public_path() . $model->file;

            if(file_exists($currentFile) && $currentFile != public_path() .'/user_placeholder.png'){
                unlink($currentFile);
            }
        }
        $file=null;
        if($type === 'user'){
            $file =  $manager->read($request->file('file'))->resize(400, 400);
        } 
        else{
            $file = $manager->read($request->file('file'));
        }
        $ext = $request->file('file');
        $extension = $ext->getClientOriginalExtension();
        $timeNow = Carbon::now();
        $name = $timeNow->format('YmdHis') . '.' . $extension;
        $file->save(public_path() . '/file/' . $name);
        $model->file = '/file/' . $name;
        return $model;
    }
}