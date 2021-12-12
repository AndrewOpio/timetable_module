<?php

namespace model\Timetable;

use model\App;

class Settings extends App
{
    private $TableName = "tbl_settings";

    public function __get_settings()
    {
        $query = "SELECT * FROM $this->TableName";
        $result = mysqli_work($query);
        if ($result->num_rows > 0) {

            $data=[];
            $i = 0;
            while($row=$result->fetch_assoc()):
                $data[$i] = $row;
                $i++;
            endwhile;
    
            $this->Success="Success";
            return $data;
        }

        $this->Error="No data found.";
        return false;
    }


    public function __add_settings($start_time, $end_time, $period)
    {
        $query = "INSERT INTO $this->TableName (start_time, end_time, period) VALUES('$start_time', '$end_time', '$period')";
        $result = mysqli_work_insert($query);

        if ($result) {
            $this->Success = "Success";
            return $result;
        }

        $this->Error = "Failed";
        return false;
    }


    public function __edit_settings()
    {
        $query = "UPDATE $this->TableName SET start_time = $start_time, end_time = $end_time, period = $period";
        $result = mysqli_work_update($query);

        if ($result) {
            $this->Success = "Success";
            return $result;
        }

        $this->Error = "Failed";
        return false;
    }


    public function __init()
    {
       //setting - id, start_time, end_time, period
       //break_point - id, start_time, end_time
       //sessi0n - id, periods

       //duration, break_point
    }
}