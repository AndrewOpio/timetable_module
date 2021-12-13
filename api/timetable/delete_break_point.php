<?php

use model\Timetable\BreakPoints;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['id']);

$NewRequest = new BreakPoints;
$result = $NewRequest->__delete_break_point(
    clean($data->id)
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
