<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PhotosControllerTest extends TestController
{
    
    public function testGetPhotos(): void
    {
        Storage::fake('public');
        
        $filename1 = 'photo1.jpg';
        $filename2 = 'photo2.png';
        
        $this->uploadFile(UploadedFile::fake()->image($filename1), 3);
        $this->uploadFile(UploadedFile::fake()->image($filename2));
        
        $response = $this->get('/api/photos');
        
        $response->assertStatus(200);
        
        $response->assertJsonCount(2);
        $response->assertJsonCount(3, '0.tags');
        $response->assertJsonCount(0, '1.tags');
        $this->assertStringStartsWith('http', $response[0]['photo_url']);
        $this->assertStringStartsWith('http', $response[1]['photo_url']);
        
        $photosFromDB = Photo::whereIn('photo_title', [$filename1, $filename2])->get();
        $photo1NameInDB = $photosFromDB[0]->getAttributes()['photo_url'];
        $photo2NameInDB = $photosFromDB[1]->getAttributes()['photo_url'];
        
        Storage::disk('public')->assertExists($photo1NameInDB);
        Storage::disk('public')->assertExists($photo2NameInDB);
    }
    
    public function testUploadPhoto() {
        Storage::fake('public');
        
        $filename = 'photo1.jpg';
        
        $this->uploadFile(UploadedFile::fake()->image($filename));
        
        $filesFromDB = DB::table('photos')->where('photo_title', '=', $filename)->get();
        Storage
            ::disk('public')->assertExists($filesFromDB[0]->photo_url);
        $this->assertCount(1, $filesFromDB);
    }

    public function testUploadPhotoFileMissing() {
        $storagePath = 'public';
        
        Storage::fake($storagePath);
        
        $filename = 'photo1.jpg';
        $response = $this->json('POST', '/api/photos', []);
        
        $response->assertBadRequest();
        
        Storage
            ::disk($storagePath)->assertMissing($filename);
    }
    
    public function testDeletePhoto() {
        $storageDisk = 'public';
        $filename = 'myImage.jpg';
        Storage::fake($storageDisk);
        
        $file = UploadedFile::fake()->image($filename);
        $response = $this->uploadFile(UploadedFile::fake()->image($filename));
        
        $filesFromDB = DB::table('photos')->where('photo_title', '=', $filename)->get();
        
        Storage
            ::disk('public')->assertExists($filesFromDB[0]->photo_url);
        
        $photoId = $filesFromDB[0]->id;
        $response = $this->json('DELETE', '/api/photos/' . $photoId);
        
        $response->assertOk();

        Storage::disk($storageDisk)->assertMissing($filesFromDB[0]->photo_url);
    }

    private function uploadFile(File $file, $numberOfTagsToCreate = 0): TestResponse {
        $response = $this->json('POST', '/api/photos', [
                'photo' => $file
        ]);

        if ($numberOfTagsToCreate > 0) {
            $photoId = $response['id'];
            $photo = Photo::find($photoId);        
            
            foreach (range(1, $numberOfTagsToCreate) as $numOfTags) {
                $tagData = [
                    'tag_title' => 'Tag'. $numOfTags,
                    'x_offset' => $numOfTags * 2,
                    'y_offset' => $numOfTags * 2
                ];

                $tag = new Tag($tagData);

                $photo->tags()->save($tag);
            }
        }
            
        return $response;
    }
}
