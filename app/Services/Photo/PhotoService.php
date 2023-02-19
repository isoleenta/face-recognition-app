<?php

namespace App\Services\Photo;

use App\Models\User;
use App\Repositories\FriendsFaceRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Python;
use Str;

class PhotoService
{
    public function __construct(
        private FriendsFaceRepository $face_repository
    ){
        //
    }

    public function createModel(UploadedFile $image, string $friend_name, User $user): void
    {
        $path = '/images/user'.'_'.$user->id.'/faces/known/';

        $image_name = $friend_name.'.'.$image->getClientOriginalExtension();

        $full_to_image = storage_path().'/app'.$path.$image_name;

        Storage::putFileAs($path, $image, $image_name);

        $encoded_model = Python::run(script: 'face_recognition_command.py', flag_and_parameter: '-r "'.$full_to_image.'"');

        $this->face_repository->create([
            'name' => $friend_name,
            'encoded_model' => $encoded_model,
            'user_id' => $user->id
        ]);
    }

    public function recognizeFriends(UploadedFile $image, User $user): string
    {
        $path = '/images/user'.'_'.$user->id.'/faces/unknown/';

        $image_name = Str::uuid().'.'.$image->getClientOriginalExtension();

        $full_to_image = '"'.storage_path().'/app'.$path.$image_name.'"';

        Storage::putFileAs($path, $image, $image_name);

        $labeled_faces = [];

        foreach ($user->friendsFaces as $labeled_face) {
            $labeled_faces[$labeled_face->name] = $labeled_face->encoded_model;
        }

        $labeled_faces_models_str = str_replace(
            "\n",
            '',
            '"['.collect(array_values($labeled_faces))->implode(', ').']" '
        );

        $labeled_faces_names_str = str_replace(
            "\n",
            '',
            '"[\''.collect(array_keys($labeled_faces))->implode('\', \'').'\']" '
        );

        $encoded_model = Python::run(
            script: 'face_recognition_command.py',
            flag_and_parameter:
            '-m '.$labeled_faces_models_str.
            '-n '.$labeled_faces_names_str.
            '-recognize '.$full_to_image
        );

        return str_replace(["\n", "None"], '',$encoded_model);
    }
}
