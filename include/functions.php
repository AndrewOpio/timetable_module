<?php

use model\Auth\Environment;

function field_exists($tab, $field)
{
    $db=Database::getInstance();
    $mysqli=$db->getConnection();
    $query="SHOW COLUMNS FROM `$tab` LIKE '$field'";
    $result=$mysqli->query($query);
    echo $mysqli->error;
    $exists=($result->num_rows)?true:false;
    return $exists;
}

function table_exists($table)
{
	$db=Database::getInstance();
    $mysqli=$db->getConnection();
    (new Environment('.env'))->load();//loads from index folder
	$query_check="SELECT*FROM information_schema.tables WHERE";
	$query_check.=" table_schema = '". getenv('DATABASE_NAME') ."' AND table_name = '$table'";
	$query_check.=" LIMIT 1;";
	$result_check=$mysqli->query($query_check);
	$num_check=$result_check->num_rows;
	$bol=$num_check>0 ? true : false;
	return $bol;
}

/**
 * Escapes sql injection
 */
function clean($string)
{
    $db=Database::getInstance();
    $mysqli=$db->getConnection();
    $string=trim($string);
    $string=mysqli_real_escape_string($mysqli, $string);
    return $string;
}

function len($string)
{
    $string=trim($string);
    if(strlen($string)>0)
    {
     return false; 
    }
    return true;
}

function capitalize($stg){
		
	return ucwords(strtolower($stg));

}


function initials($str) 
{
		$str=trim($str);
    $ret = "";
    foreach (explode(' ', $str) as $word)
	if(isset($word[0])){
        $ret .= strtoupper($word[0]);
 
	}
	return $ret;
}

function congrats($message)
{

    $error='<div class="alert alert-success" role="alert">
    <strong>Success! </strong>'. $message .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';
return $error;

}
                    		
					
function warn_user($message)
{
    $error='<div  class="alert alert-danger" role="alert">
        <strong>Oops! </strong>'. $message .'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
    return $error;
}

function inform_user($message)
{
    $error='<div class="alert alert-info" role="alert">
    <strong>Info: </strong>'. $message .'
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';
return $error;

}




function stroked_picker_format($date){
    $picked=date('m/d/Y', strtotime($date));
    
	return $picked;
}
function picker_format($date){
    return date('d M Y', strtotime($date));
}
function db_date($date_db){
	$date_db=date('Y-m-d', strtotime($date_db));
	return $date_db;
}
function user_date($date_user){
	$date_user=date('D, d M Y', strtotime($date_user));
	if($date_user=="Thursday, 01-Jan-1970"){
		$date_user="Day-Month-Year";
	}
	return $date_user;
}

function redirect_to($new_page){
	header("Location: $new_page");
	return $new_page;
}


function cut_words($limit, $words)
{
    $paragraph=$words;
    $lim=$limit;
    $short_words=substr($paragraph, 0, $lim);
    
    if((strlen($short_words))<(strlen($paragraph))){
        $short_words=$short_words . "...";
    }else{
        $short_words=$short_words;
    }
    
   return $short_words;
}
  

function upload_file($input_field, $extensions, $uploadDirectory, $old_file="0", $allowed_size=5000000)
{
        //this function return the new file name and the old file name;
        //$currentDir = getcwd();
        $errors = []; // Store all foreseen and unforseen errors here
        $fileName = $_FILES[$input_field]['name'];
        $fileSize = $_FILES[$input_field]['size'];
        $fileTmpName  = $_FILES[$input_field]['tmp_name'];
        $fileType = $_FILES[$input_field]['type'];
        $file_info=pathinfo($fileName, PATHINFO_EXTENSION);
        $fileExtension = strtolower($file_info);
        $level="fil_ara_" . time();
        $new_file_name=clean($level . "." . $fileExtension);
        
        if (!in_array($fileExtension,$extensions)) {
            $errors[] = "Invalid file format";
        }

        if ($fileSize > $allowed_size) {
            $errors[] = "Invalid file size";
        }
        
        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadDirectory.$new_file_name);
            if(strlen($old_file)>3)
            {
                if(file_exists($uploadDirectory.$old_file))
                {
                    unlink($uploadDirectory.$old_file);
                }
            }

            if ($didUpload) {
                return array($new_file_name, $fileName);
            } else {

                return false;
                $errors[]="Unknown error occured during file upload";
                return array("error"=>$errors);
            }
        }else
        {
            return false;
            return array("error"=>$errors);
        }

        
}//ends upload file function



function user_date_time($date_user_time){
	$date_user=date('D, d M Y', strtotime($date_user_time));
	$time_user=date('h:i a', strtotime($date_user_time));
	return $date_user . " at " . $time_user;
}

function user_date_day($date_user_time){
	$date_user=date('D, d M Y', strtotime($date_user_time));
	return $date_user;
}

function short_date($date_user){
	$date_user=date('d M Y', strtotime($date_user));
	if($date_user=="Thursday, 01-Jan-1970"){
		$date_user="Day-Month-Year";
	}
	return $date_user;
}


function user_time($user_time){
	if($user_time=="00:00:00" || $user_time==NULL){ 
		return "--:--"; 
		}
	
	$time_user=date('h:i a', strtotime($user_time));
	return $time_user;
}


function tell_when($date_added){
    $today=date('Y-m-d H:i:s');
    $days=get_time_difference(db_date($date_added), $today);
    $days=$days['days'];
    if($days==-1)
    {
        return "Tommorrow at " . user_time($date_added);
    }elseif($days==0){
        return "Today at " . user_time($date_added);
    }elseif($days==1){
        return "Yesterday at " . user_time($date_added);
    }else{
        return user_date_time($date_added);
    }

}

function tell_when_long($date_added){
    $today=date('Y-m-d H:i:s');
    $days=get_time_difference(db_date($date_added), $today);
    $days=$days['days'];
    if($days==0){
        return "Today at " . user_time($date_added);
    }elseif($days==1){
        return "Yesterday at " . user_time($date_added);
    }elseif($days>1 && $days<=4){
        return $days . " days back at " . user_time($date_added);
    }else{
        return user_date_time($date_added);
    }

}


function get_time_difference($start, $end, $conv=0)
{
    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );
    if( $uts['start']!==-1 && $uts['end']!==-1 )//>=past
    {
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff ); 
				if($conv==0){
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
				}elseif($conv==10){
					$addition=($hours*60)+$minutes+$diff;
					return $addition;
				}
				else{
					$addition=($hours*60)+$minutes;
					return $addition;
				}
		}
        else//future ||>now
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff ); 
				if($conv==0){
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
				}elseif($conv==10){
					$addition=($hours*60)+$minutes+$diff;
					return $addition;
				}
				else{
					$addition=($hours*60)+$minutes;
					return $addition;
				}
            //trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}


function today_plus_days($days){
    $NewDate=Date('Y-m-d', strtotime("+".$days." days"));
    return $NewDate;
}//ends today_plus_days

function today_minus_days($days){
    $NewDate=Date('y-m-d', strtotime("-".$days." days"));
    return $NewDate;
}//ends today_plus_days

function date_plus_days($old_date, $days){
    $NewDate=Date('Y-m-d H:i:s', strtotime($old_date . "+".$days." days"));
    return $NewDate;
}//ends today_plus_days

function vo_no($no, $length=6){
	if(is_numeric($no))
	{
		return str_pad($no, $length, 0, 0);
	}
	return $no;
	
}




function plural($word, $num, $new=0){
	
	if($num>1){
		$formed=$word . "s";
	}else{
	 	$formed=$word;
	}
		if($new==0){
			return $formed;
		}
		if($num>1){
			return $formed . " are ";
		}
		return $formed . " is ";
}

function alpha_num($len=5)
{
 
    $permitted_chars = '0123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
    $gene=substr(str_shuffle($permitted_chars), 0, $len);
    return $gene;

}


function send_mail($RecipientName, $RecipientAddress, $Subject="QuickPost Email Verification", $Message="Body text", $auto_path="")
{
        require $auto_path . 'mail/PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Mailer = "smtp";
        $mail->Host = "mail.quickpostug.com";
        $mail->Port = "465"; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = "support@quickpostug.com";
        $mail->Password = "7leonnard7?";
        $mail->SMTPDebug  = false;         
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $mail->FromName = $RecipientName;
        foreach($RecipientAddress as $key=>$value):
            $mail->From = "support@quickpostug.com";
            $mail->AddAddress($value, $RecipientName);
        endforeach;
        
        
        $mail->isHTML(true); 

        $mail->AddReplyTo("andrizar2@gmail.com", "QuickPost");
        $mail->Subject = $Subject;
        $mail->Body = $Message;
        $mail->WordWrap = 50;

        if(!$mail->Send()) {
        //echo 'Email was not sent.';
        //echo 'Mailer error: ' . $mail->ErrorInfo;
        return false;
        exit;
        } else {
        //echo 'Email has been sent.';
        return true;
        }
                        
}


        function auth_code($len=6)
        {
        
            $permitted_chars = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
            $gene=substr(str_shuffle($permitted_chars), 0, $len);
            return $gene;

        }

        function auto_number($size=4)
        {
        
            $permitted_chars = '0123456789';
            $gene=substr(str_shuffle($permitted_chars), 0, $size);
            return $gene;

        }


     
        function format_phone_number($number, $plus=false)
        {
            if($number=="none" || $number==""){
                return false;//invalid
            }

            $number=str_replace("+", "", $number);
            
            $non_space=explode(" ", $number);
            $number_pieces=array();
            
            foreach($non_space as $key=>$value){
                $number_pieces[]=trim($value);
            }

            $number=implode("", $number_pieces);
            
            $non_slash=explode("/", $number);
            $number_pieces=array();
            
            foreach($non_slash as $key=>$value)
            {
                $number_pieces[]=trim($value);
            }
            
            $number=$number_pieces[0];
            $num=substr($number, 0, 1);
            if($num=="0")
            {
                $new="256" . substr($number, 1);
                //return $new;
            }
            else{
                $new=$number;
            }
            if(strlen($new)!=12)
            {
                return false;
            }
            return $plus?"+".$new : $new;
        }

        function acc_creator()
        {
            $length=5;
            srand((float)microtime()*1000000);
            $number='';
            for($i=0; $i<$length; $i++)
            {
                $number.=rand(0,9);
            }
            return $number;
        }

        function now_plus_reset($days=1){
            $NewDate=Date('Y-m-d H:i:s', strtotime("+".$days." days"));
            return $NewDate;
        }//ends today_plus_days



        /*********SMS HELPER FUNCTIONS */

        function get_sms_balance()
        {
            $query="SELECT `balance` FROM `tbl_sms_balance`";
            $result=mysqli_work($query);
            $row=$result->fetch_assoc();
            return $row['balance'];
        }

      
        function increase_sms_balance($amount)
        {
            $new_balance=get_sms_balance()+$amount;
            if($new_balance<=0)
            {
                return false;
            }
            $data=array(
                "balance"=>$new_balance
            );
            $updated=mysqli_update_data("tbl_sms_balance", $data, 1);
            if($updated)
            {
                return true;
            }
            return false;
         }

        
         function get_sms_cost($message)
         {
             $length=strlen($message);
             $std_characters=159;
             $cost=30;
             $total_sms=ceil($length/$std_characters);
             return $cost*$total_sms;
         }
        


        

        function phone_notify_user($message, $number, $head=0)
        {

           return true;// delete this in production

            if($head>0)
            {
                $message="QuickPost: " . $message;
            }
           


            /*
            
             $message=urlencode($message);
            $url = "https://api.africastalking.com/version1/messaging";
            $auth="0c9eca2069904c60fe4c4796e0b5fb1280fcab41f1bcb0779db5572bcd537d3b";
           
            $data ="username=quickpost&to=".$number . "&message=".$message;
           
               
            //$json = json_encode($data);
            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $headers[] = 'apiKey:'. $auth;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); // Do not send to screen
            curl_setopt($ch, CURLOPT_USERAGENT, 'QUICKPOST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            $response=curl_exec($ch);
            curl_close($ch);
            //if($response)
           // $response=json_decode($response);
            return $response;
            
                    */


                    //     //log messages
                    //    $logged=deduct_sms_balance($message, $number);
                    //    if(!$logged)
                    //    {
                    //        //return false;
                    //    }

                    /**
                     * Below if afrosms
                     */

            $message=urlencode($message);
            $url="https://www.afrosms.ug/smskings/api.php?email=andrizar2@gmail.com&message=$message&password=Kizito_2016&destination=$number&source=CASHMONEY&call=sendsms";
			$curl = curl_init();
			curl_setopt ($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec ($curl);
            curl_close ($curl);
            

            /**
             * Below is pandora
             */

            // $data ="username=0704722190&password=Admin6699&number=".$number . "&message=".$message . "&sender=QuickPost";
            
            // //$data=urlencode($data);
            // $url="https://sms.thepandoranetworks.com/API/sendSMS/?".$data;
			// $curl = curl_init();
			// curl_setopt ($curl, CURLOPT_URL, $url);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			// $result = curl_exec ($curl);
            // curl_close ($curl);

        }




        function mysqli_update($table, $data, $id)
        { 
            $query="UPDATE `$table` SET ";
            $records=[];
            foreach($data as $field=>$value)
            {
                $records[]="`$field`='$value'";
            }
            $query.=implode(", ", $records);
            $query.=" WHERE `id`='$id'";
            return $query;
        }

        function gen_uuid() {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        
                // 16 bits for "time_mid"
                mt_rand( 0, 0xffff ),
        
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand( 0, 0x0fff ) | 0x4000,
        
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand( 0, 0x3fff ) | 0x8000,
        
                // 48 bits for "node"
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }



        // Comparison function 
        function date_compare($element1, $element2) { 
            $datetime1 = strtotime($element1['date']['db_date']); 
            $datetime2 = strtotime($element2['date']['db_date']); 
            return $datetime1 - $datetime2; 
        }  

         // Comparison function 
         function key_compare($element1, $element2) { 
            $key1 = strtotime($element1['key']); 
            $key2 = strtotime($element2['key']); 
            return $key1 - $key2; 
        }  


        function require_api_data($data, $fields=[])
        {
            foreach($fields as $key=>$field)
            {
                if(!isset($data->$field))
                {
                    $info=array(
                        'status' => 'Fail',
                        'message'=>"Parameter " . $field . " is not specified",
                        'details' => array("Parameter " . $field . " is not specified")
                    );
                    print_r(json_encode($info));
                
                    exit;
                }
            }
        }

        function require_api_headers(): void
        {

              header('Access-Control-Allow-Credentials: true');
              header('Authorization: Bearer ');
              header('Access-Control-Allow-Origin: *');
              header("Access-Control-Allow-Methods: POST");
              header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization, Source");
              header('Content-Type: application/json');
              $method = $_SERVER['REQUEST_METHOD'];
              if ($method == "OPTIONS") {
                  header('Access-Control-Allow-Origin: *');
                  header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization, Source");
                  header("HTTP/1.1 200 OK");
                  die();
              }
        }




        function mysqli_work($query)
        { 
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            $result=$mysqli->query($query);
            echo $mysqli->error;
            return $result;
        }
    
        function mysqli_work_insert($query)
        { 
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            $result=$mysqli->query($query);
            echo $mysqli->error;
            $id=$mysqli->insert_id;
            if($mysqli->affected_rows>0)
            {
                return $id;
            }
            return false;
        }
    
    
        function mysqli_work_insert_count($query)
        { 
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            $result=$mysqli->query($query);
            echo $mysqli->error;
            return $mysqli->affected_rows;
    
        }


        function mysqli_insert($table, $data)
        {  
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            #Get array keys
            $keys=array_keys($data);
            $values=[];
            $fields=[];
            foreach($keys as $key=>$field)
            {
                $fields[]="`".$field . "`";
    
                
                if($data[$field]!="NOW()")
                {
                    
                    $values[]=len($data[$field])?'NULL':"'".$data[$field] . "'";
    
                }else{
                    $values[]=len($data[$field])?'NULL':$data[$field];
                }
            }
            $query="INSERT INTO `$table`";
            $query.="(";
            $query.=implode(", ", $keys);
            $query.=")VALUES(";
            $query.=implode(", ", $values);
            $query.=")";
            $result=$mysqli->query($query);
            echo $mysqli->error;
            $id=$mysqli->insert_id;
            if($mysqli->affected_rows>0)
            {
                return $id;
            }
            return false;
        }
    
        function mysqli_update_data($table, $data, $id, $base_field="ID")
        { 
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            $query="UPDATE `$table` SET ";
            $records=[];
            foreach($data as $field=>$value)
            {
    
                if($data[$field]!="NOW()")
                {
                    $records[]=len($value)?"`$field`=NULL":"`$field`='$value'";
                }else{
                    $records[]=len($value)?"`$field`=NULL":"`$field`=$data[$field]";
 
                }
            }
            $query.=implode(", ", $records);
            $query.=" WHERE `$base_field`='$id'";
            $result=$mysqli->query($query);
            echo $mysqli->error;
            if($mysqli->affected_rows>0)
            {
                return true;
            }
            return false;
        }


        function mysqli_insert_count($table, $data)
        {  
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            #Get array keys
            $keys=array_keys($data);
            $values=[];
            $fields=[];
            foreach($keys as $key=>$field)
            {
                $fields[]="`".$field . "`";
    
                
                if($data[$field]!="NOW()")
                {
                    
                    $values[]=len($data[$field])?'NULL':"'".$data[$field] . "'";
    
                }else{
                    $values[]=len($data[$field])?'NULL':$data[$field];
                }
            }
            $query="INSERT INTO `$table`";
            $query.="(";
            $query.=implode(", ", $keys);
            $query.=")VALUES(";
            $query.=implode(", ", $values);
            $query.=")";
            $result=$mysqli->query($query);
            echo $mysqli->error;
            $id=$mysqli->insert_id;
            if($mysqli->affected_rows>0)
            {
                return $mysqli->affected_rows;
            }
            return false;
        }



        function mysqli_work_update($query)
        { 
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            $mysqli->query($query);
            echo $mysqli->error;
            if($mysqli->affected_rows>0)
            {
                return $mysqli->affected_rows;
            }
            return false;
        }
    
        function secure_url($string)
        {
            //$string=urlencode($string);
            return $string;
        }

        function sql_today($field)
        {
            $query=" DATE($field)=CURDATE()";
            return $query;
        }

        function sql_this_month($field)
        {
            $query=" MONTH($field)=MONTH(CURDATE())";
            $query.=" AND YEAR($field)=YEAR(CURDATE())";
            return $query;
        }

        function sql_minute_timer($field)
        {
            $query="TIMESTAMPDIFF(MINUTE, $field, NOW()) AS `timer`";
            return $query;
        }


        function sql_last_month($field)
        {

            $query=" YEAR($field) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)";
            $query.=" AND MONTH($field) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)";
            return $query;
        }


        function sql_this_year($field)
        {

            $query=" YEAR($field) = YEAR(CURRENT_DATE)";
            return $query;
        }

        function date_formats($field, $blank=false)
        {
            if(!$blank)
            {
                return array(
                    "long_date"=>user_date_day($field),
                    "short_date"=>picker_format($field),
                    "when"=>tell_when($field),
                    "time"=>user_time($field)
                );
            }else{
                return array(
                    "long_date"=>"--:--",
                    "short_date"=>"--:--",
                    "when"=>"--:--",
                    "time"=>"--:--"
                );
            }
           
        }

        function mysqli_delete($table, $id)
        {  
            $db=Database::getInstance();
            $mysqli=$db->getConnection();
            $query="DELETE FROM `$table` WHERE `id`='$id'";
            $result=$mysqli->query($query);
            if($mysqli->affected_rows>0)
            {
                return true;
            }
            return false;
        }


        function int_format($int, $key="total")
        {
            return array(
                "$key"=>$int,
                "$key"."_c"=>number_format($int),
                "$key"."_p"=>vo_no($int, 2)
            );
        }


        function format_email($email)
        {
            #validating email address
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                return false;
            }

            return $email;
        }


        function clean_text($string)
        {
            $string=clean($string);
            if(len($string))
            {
                return "N/A";
            }
            return $string;
        }


        function shorten_phrase($phrase, $depth=2, $reverse=true)
        {
            $words=explode(" ", $phrase);
            $size=count($words);
            if($size>=$depth)
            {
                $new_words=$reverse?array_slice($words, $depth*-1, $depth):array_slice($words, 0, $depth);
                return implode(" ", $new_words);
            }

            return $phrase;
        }
       

        function get_file_path($file_path)
        {
            #try first directory
            $path="../".$file_path;
        
            if(file_exists($path))
            {
                return $path;
            }else{
                return "../../".$file_path;
            }
        }

    function validate_provider_phones($mobile_number)
    {
        if(!$mobile_number=format_phone_number($mobile_number))
        {
            return false;
        }
        $mtn=array(
            "25677",
            "25678",
            "25630",
            "25631",
            "25632",
            "25633",
            "25634",
            "25635",
            "25636",
            "25637",
            "25638",
            "25639",
        );

        $identifier=substr($mobile_number, 0, 5);
        $custom_identifier=substr($mobile_number, 0, 9);
        $provider=false;

        if($custom_identifier=="256323300")
        {
            $provider="CYBER";
        }
        elseif($identifier==="25670" || $identifier==="25675")
        {
            $provider="AIRTEL";
        }
        elseif(in_array($identifier, $mtn))
        {
            $provider="MTN";
        }elseif($identifier=="25679"){
            $provider="AFRICELL";
        }
        return $provider;

    }

    /**
     * GETS THE URL STRING
     * -Specify the uri_depth if your host has multiple slashes
     * E.g for localhost/app/app_name     ---- url_depth=1;//number_of_slashes minus 1
     */
    function get_request_name($uri_depth=0)
    {
        $url=$_SERVER['REQUEST_URI'];
        $clean_url=explode("?", $url);
        $url=$clean_url[0];
        $request = explode("/", $url);
        $parts=[];
        foreach($request as $key=>$value)
        {
            if($key>$uri_depth)
            {
                $parts[]=$value;
            }
        }
        $request=implode("/", $parts);
        return $request;
    }

    function get_host()
    {
        $url=$_SERVER['SCRIPT_NAME'];
        $parts=explode("/", $url);
        $new_parts=[];
        for($i=0; $i<(sizeof($parts)-1); $i++)
        {
            $new_parts[]=$parts[$i];
        }
        return implode("/", $new_parts);
    }

    function get_request_params()
    {
        $url=$_SERVER['REQUEST_URI'];
        $request = explode("?", $url);
        if(isset($request[1]))
        {
            return $request[1];
        }
        return false;
    }


function format_phone_search($number)
{
    $num=substr($number, 0, 1);
    if($num=="0")
    {
        $new="256" . substr($number, 1);
        //return $new;
    }
    else{
        $new=$number;
    }

    return $new;
}



function post_data_to_url($url, $data)
{
           
               
            $json = json_encode($data);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); // Do not send to screen
            curl_setopt($ch, CURLOPT_USERAGENT, 'QUICKPOST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            $response=curl_exec($ch);
            curl_close($ch);
            //if($response)
           // $response=json_decode($response);
            return $response;
}



function mysqli_import($src_table, $dest_table, $data)
{  
    $db=Database::getInstance();
    $mysqli=$db->getConnection();
    #Get array keys
    $keys=array_keys($data);
    $values=[];
    $fields=[];
    foreach($keys as $key=>$field)
    {
        $fields[]="`". $field . "`";
        $values[]=!is_array($data[$field])?"`". $data[$field] . "`": "'" .$data[$field][0] . "'";
    }
    $query="INSERT INTO `$dest_table`";
    $query.="(";
    $query.=implode(", ", $fields);
    $query.=") SELECT ";
    $query.=implode(", ", $values);
    $query.=" FROM `$src_table`;";

    echo $query;
    // $result=$mysqli->query($query);
    // echo $mysqli->error;
    // $id=$mysqli->insert_id;
    // if($mysqli->affected_rows>0)
    // {
    //     return $id;
    // }
    // return false;
}

?>