<?php

use model\Timetable\Settings;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, []);

$NewRequest = new Settings;
$result = $NewRequest->__edit_settings();

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
