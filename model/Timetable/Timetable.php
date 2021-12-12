<?php

namespace model\Timetable;

use model\App;

class Timetable extends App
{
    private $TableName = "tbl_timetable";

    public function __get_timetable()
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


    public function __add_entry($subject, $time, $teacher, $day, $class)
    {
        $query = "INSERT INTO $this->TableName (subject, time, teacher, day, class) VALUES('$subject', '$time', '$teacher', '$day', '$class')";
        $result = mysqli_work_insert($query);

        if ($result) {
            $this->Success = "Success";
            return $result;
        }

        $this->Error = "Failed";
        return false;
    }


    public function __edit_timetable($subject, $time, $teacher, $day, $class)
    {
        $query = "UPDATE $this->TableName SET subject = $subject, time = $time, teacher = $teacher, day = $day, class = $class WHERE id = $id";
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
        $this->Success="Success  is nice";
        //subject fkey, time, teachers fkey, day, class
    }
}