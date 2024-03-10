<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Http\Request;
use function response;

class TagsController extends Controller
{

    public function createTagForPhoto(Request $request, $photoId)
    {
        $tagData = $request->all([
            'tag_title',
            'x_offset',
            'y_offset'
        ]);
        
        $tag = new Tag($tagData);
        $photo = Photo::find($photoId);        
        
        $photo->tags()->save($tag);
        
        return response($tag);
    }
    
    public function updateTag(Request $request, $tagId) {
        $tagData = $request->all('tag_title');
        
        Tag::where('id', '=', $tagId)->update($tagData);
        
        return Tag::find($tagId);
    }
}
