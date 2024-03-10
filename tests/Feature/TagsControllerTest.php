<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TagsControllerTest extends TestController
{
    
    public function testSaveNewTag(): void
    {
        $filename = $this->uploadFakePhoto();
        
        $fileFromDB = Photo::where('photo_title', '=', $filename)->first();
        
        $tagData = [
            'tag_title' => 'Head Lamp',
            'x_offset' => '15.00000000',
            'y_offset' => '25.00000000'
        ];

        $response = $this->post("/api/photos/{$fileFromDB->id}/tags", $tagData);
        
        $this->assertDatabaseHas('tags', $tagData);
        $this->assertDatabaseCount('tags', 1);

        $response->assertStatus(200);
    }
    
    public function testUpdateTag(): void
    {   
        $filename = $this->uploadFakePhoto();
        
        $fileFromDB = Photo::where('photo_title', '=', $filename)->first();

        $tagData = [
            'tag_title' => 'Head Lamp',
            'x_offset' => '15.00000000',
            'y_offset' => '25.00000000',
            'photo_id' => $fileFromDB->id
        ];
        
        $tag = $fileFromDB->tags()->create($tagData);
        
        $updateTagData = [
            'tag_title' => "Car Tire"
        ];

        $response = $this->put("/api/tags/{$tag->id}", $updateTagData);
        
        $this->assertDatabaseHas(
            'tags',
            array_merge($updateTagData, ['id' => $tag->id])
        );
        $this->assertDatabaseCount('tags', 1);
        $response->assertJsonFragment(array_merge($tagData, $updateTagData));

        $response->assertStatus(200);
    }
    
    private function uploadFakePhoto() {
        Storage::fake('public');
        
        $filename = 'photo1.jpg';
        
        $this->json('POST', '/api/photos', [
            'photo' => UploadedFile::fake()->image($filename)
        ]);
        
        return $filename;
    }
}
