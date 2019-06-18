<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\User;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        if ($users) {
            foreach ($users as $k => $user) {
                $data = [
                    [
                        'user_id' => $user->id,
                        'file_name' => 'file_'.Str::random(10).'.mp4',
                        'file_size' => (float)rand(1,100),
                        'viewers_count' => rand(1,100),
                    ],
                    [
                        'user_id' => $user->id,
                        'file_name' => 'file_'.Str::random(10).'.mp4',
                        'file_size' => (float)rand(1,100),
                        'viewers_count' => rand(1,100),
                    ],
                ];
                DB::table('videos')->insert($data);
            }
        }
    }
}
