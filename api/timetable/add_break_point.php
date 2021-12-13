<?php

use model\Timetable\BreakPoints;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['start_time', 'end_time']);

$NewRequest = new BreakPoints;
$result = $NewRequest->__add_break_point(
    clean($data->start_time),
    clean($data->end_time)
);

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
