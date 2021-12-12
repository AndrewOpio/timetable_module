<?php

use model\User\User;

require_api_headers();
$data=json_decode(file_get_contents("php://input"));
require_api_data($data, ['username', 'password']);


$NewRequest=new User;
$result=$NewRequest->__login(clean($data->username), clean($data->password));

if($result) 
{
    $info=array(
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

//make json
print_r(json_encode($info));

?>