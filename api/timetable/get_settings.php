<?php

use model\Timetable\Settings;

require_api_headers();

$NewRequest = new Settings;
$result = $NewRequest->__get_settings();

if ($result)
{
    $info = array(
        'status' => "OK",
        'message'=>$NewRequest->Success,
        'details' =>[$result]
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

