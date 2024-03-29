<?php

namespace model\Timetable;

use model\App;

class BreakPoints extends App
{
    private $TableName = "tbl_break_points";

    public function __get_break_points()
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



    public function __add_break_point($start_time, $end_time)
    {

        $query = "SELECT * FROM $this->TableName WHERE start_time = '$start_time' OR end_time = '$end_time'";
        $result = mysqli_work($query);

        if ($result->num_rows > 0) {
            $this->Error = "This break point already exist.";
            return false;

        } else {
            $query = "INSERT INTO $this->TableName (start_time, end_time) VALUES('$start_time', '$end_time')";
            $result = mysqli_work_insert($query);

            if ($result) {
                $this->Success = "Success";
                return $result;
            }

            $this->Error = "Failed";
            return false;
        }
    }


    
    public function __edit_break_point()
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



    public function __delete_break_point($id)
    {
        $result = mysqli_delete($this->TableName, $id);
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
    }
}