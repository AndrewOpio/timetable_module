<?php

use model\Timetable\BreakPoints;

require_api_headers();

$NewRequest = new BreakPoints;
$result = $NewRequest->__get_break_points();

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

