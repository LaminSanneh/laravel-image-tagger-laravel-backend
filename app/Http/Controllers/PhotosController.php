<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function getPhotos() {
        return Photo
            ::with('tags:id,tag_title,x_offset,y_offset,photo_id')
            ->get(['photos.id','photos.photo_title', 'photos.photo_url']);
    }
    
    public function getPhoto(int $id) {
        return Photo::with('tags')->find($id);
    }
    
    public function uploadPhotos(Request $request) {
        
        $file = $request->file('photo');
        $fileUploaded = false;
        
        if ($file && $file->isValid()) {
            $fileUploaded = Storage::disk('public')->put('', $file);            
        }
        
        $fileDBTitle = $file->getClientOriginalName();
        $fileDiskStorageTitle = $fileUploaded;

        if ($fileUploaded) {    
            \Illuminate\Support\Facades\DB
                ::table('photos')
                ->insert([
                    'photo_title' => $fileDBTitle,
                    'photo_url' => $fileDiskStorageTitle,
                ]);

            return response('');
        } else {
            return response('', \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }
    }
}
