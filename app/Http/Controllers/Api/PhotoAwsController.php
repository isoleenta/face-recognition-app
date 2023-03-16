<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhotoRequests as PhotoRequests;
use App\Services;
use Response;

class PhotoAwsController extends Controller
{
    public function __construct(
        private Services\Photo\PhotoAwsService $photo_service
    ) {
        //
    }

    public function storeImageToAWS(PhotoRequests\AddKnownFaceRequest $request)
    {
        $user = $request->user();

        $this->photo_service->storeImageToAWS($request->image, $request->friend_name, $user);

        return Response::send(true);
    }

//    public function recognizeFriends(PhotoRequests\AddKnownFaceRequest $request)
//    {
//        $user = $request->user();
//
//        $result = $this->photo_service->recognizeFriends($request->image, $user);
//
//        return Response::send(['name' => $result]);
//    }
}
