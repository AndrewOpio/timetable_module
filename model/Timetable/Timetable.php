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
            
            $time1 = "10:00:00";
            $time2 = "11:00:00";
            $time3 = "10:45:00";


            if ($time3 > $time1 && $time3 < $time2) {
                $this->Success="Success";
            } else {
                $this->Success="Try again.";
            }

            return $data;
        }

        $this->Error="No data found.";
        return false;
    }


    public function __add_entry($subject, $time, $teacher, $day, $class)
    {

        $query = "SELECT * FROM $this->TableName WHERE teacher = '$teacher' AND day = '$day' AND time = '$time'";
        $result = mysqli_work($query);

        if ($result->num_rows > 0) {
            $this->Error = "This slot is already taken by this teacher.";
            return false;

        } else {
            $query = "INSERT INTO $this->TableName (subject, time, teacher, day, class) VALUES('$subject', '$time', '$teacher', '$day', '$class')";
            $result = mysqli_work_insert($query);

            if ($result) {
                $this->Success = "Success";
                return $result;
            }

            $this->Error = "Failed";
            return false;
       }
    }


    public function __edit_timetable($id, $subject, $time, $teacher, $day, $class)
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


    public function __delete_entry($id)
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
        //subject fkey, start_time, teachers fkey, day, class, status, periods
    }
}