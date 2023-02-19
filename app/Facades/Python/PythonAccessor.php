<?php

namespace App\Facades\Python;

use Illuminate\Support\Facades\Process;
use Response;

class PythonAccessor
{
    public function __construct()
    {
        //
    }

    public function run(string $script, string $flag_and_parameter)
    {
        $result = Process::run('python3 '.resource_path().'/python/'.$script.' '.$flag_and_parameter);

        abort_if(
            $result->failed(),
            Response::BAD_REQUEST,
            'Fail to run python script'
        );

        return $result->output();
    }
}
