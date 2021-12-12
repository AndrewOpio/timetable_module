<?php

use model\Timetable\Timetable;

require_api_headers();

$NewRequest = new Timetable;
$result = $NewRequest->__get_timetable();

if ($result)
{
    $info = array(
        'status' => "OK",
        'message'=>$NewRequest->Success,
        'details' =>$result
    );
}
else
{
    $info=array(
        'status' => 'Fail',
        'message'=>$NewRequest->Error,
        'details' =>[$result]
    );
}

print_r(json_encode($info));
