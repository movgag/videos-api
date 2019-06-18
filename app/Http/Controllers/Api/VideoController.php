<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Video;
use App\User;

class VideoController extends Controller
{
    public $successStatus = 200;
    public $dangerStatus = 422;

    /**
     * videos api / updating the metadata of the video
     *
     * @return \Illuminate\Http\Response
     */

    public function updateVideoMetadata(Request $request)
    {
        $rules = [
            'id' => 'required|exists:videos',
            'file_size' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'viewers_count' => 'required|integer|digits_between:1,20',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return \Response::json([
                'type' => 'error',
                'message' => $validator->errors()->first(),
                'data' => []
            ],
            $this->dangerStatus);
        }

        $input = $request->only(['file_size','viewers_count']);

        $res = Video::where('id',$request->post('id'))->update($input);

        if (!$res) {
            return \Response::json([
                'type' => 'error',
                'message' => 'Something went wrong.',
                'data' => []
            ],
            $this->dangerStatus);
        }

        return response()->json([
            'type'=>'success',
            'message' => 'The metadata of the video is successfuly updated.',
            'data' => [],
        ], $this->successStatus);
    }

    /**
     * videos api / getting total size of user's videos
     *
     * @return \Illuminate\Http\Response
     */

    public function getVideosTotalSize($username)
    {
        $rules = [
            'username' => 'required|exists:users',
        ];

        $validator = Validator::make(['username' => $username], $rules);

        if ($validator->fails()) {

            return \Response::json([
                'type' => 'error',
                'message' => $validator->errors()->first(),
                'data' => []
                ],
                $this->dangerStatus);
        }

        $user = User::where('username', $username)->first();

        $total_video_size = $user->videos->sum('file_size');

        return response()->json([
            'type'=>'success',
            'message' => 'The total videos size of the specific user',
            'data' => [
                'total_video_size' => $total_video_size,
            ],
        ], $this->successStatus);
    }

    /**
     * videos api / getting metadata of specific video
     *
     * @return \Illuminate\Http\Response
     */

    public function getVideoMetadata($id)
    {
        $rules = [
            'id' => 'required|exists:videos',
        ];

        $validator = Validator::make(['id' => $id], $rules);

        if ($validator->fails()) {

            return \Response::json([
                'type' => 'error',
                'message' => $validator->errors()->first(),
                'data' => []
                ],
                $this->dangerStatus);
        }

        $video = Video::find($id);

        return response()->json([
            'type'=>'success',
            'message' => 'The metadata of the specific video',
            'data' => [
                'file_size' => $video->file_size,
                'viewers_count' => $video->viewers_count,
                'created_by' => $video->user->username, // unique username
            ],
        ], $this->successStatus);
    }
}
