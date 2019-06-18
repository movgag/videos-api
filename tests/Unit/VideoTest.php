<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Video;
use App\User;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that it is possible to get correct metadata of a video
     *
     * @return void
     */
    public function test_can_see_metadata_of_video() {
        // creating a video (and user)
        $video = factory(Video::class)->create();

        // getting created user
        $user = User::find($video->user_id);

        // collecting data
        $data = [
            'id' => $video->id,
        ];

        // calling appropriate root
        $response = $this->get(route('videos.get.metadata',$data))
            ->assertStatus(200);

        // asserting that the data from response matches with the data from db
        $this->assertTrue($response->getData()->data->file_size == $video->file_size);
        $this->assertTrue($response->getData()->data->viewers_count == $video->viewers_count);
        $this->assertTrue($response->getData()->data->created_by == $user->username);
    }


    /**
     * Test that it is possible to get correct metadata of a video
     *
     * @return void
     */
    public function test_can_see_total_size_of_videos_of_the_user() {

        // creating an user
        $user = factory(User::class)->create();

        // creating videos for that user with random count
        $rand = rand(1,10);
        factory(Video::class, $rand)->create([
            'user_id'=>$user->id
        ]);

        // collecting data
        $data = [
            'username' => $user->username,
        ];

        // calling appropriate root
        $response = $this->get(route('videos.get.total.size',$data))
            ->assertStatus(200);

        $total_video_size_from_response = $response->getData()->data->total_video_size;

        $total_video_size_from_db = $user->videos->sum('file_size');

        // asserting that the data from response matches with the data from db
        $this->assertTrue($total_video_size_from_response == $total_video_size_from_db);
    }

    /**
     * Test that it is possible to update the metadata of any video
     *
     * @return void
     */

    public function test_can_update_metadata_of_the_video()
    {
        // creating a video (and user)
        $video = factory(Video::class)->create();

        $rand_file_size = (float)rand(1,100);
        $rand_viewers_count = rand(1,100);

        // collecting data
        $data = [
            'id' => $video->id,
            'file_size' => $rand_file_size,
            'viewers_count' => $rand_viewers_count,
        ];

        // calling appropriate root
        $this->patch(route('videos.update'),$data)
            ->assertStatus(200);

        // getting updated video
        $updated_video = Video::find($data['id']);

        // asserting that the data is successfuly updated
        $this->assertTrue($data['file_size'] == $updated_video->file_size);
        $this->assertTrue($data['viewers_count'] == $updated_video->viewers_count);


    }
    
}
