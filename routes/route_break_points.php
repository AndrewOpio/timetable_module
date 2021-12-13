<?php
    switch($request):
        case "timetable/break_points/add"://get timetable break_points route
                include_once "api/timetable/add_break_point.php";//Get timetable break_points Endpoint
                exit;
            break;

        case "timetable/break_points/edit"://get timetable break_points route
                include_once "api/timetable/edit_break_points.php";//Get timetable break_points Endpoint
                exit;
            break;

        case "timetable/break_points/get"://get timetable break_points route
                include_once "api/timetable/get_break_points.php";//Get timetable break_points Endpoint
                exit;
            break;

        case "timetable/break_points/delete"://delete timetable break_points route
                include_once "api/timetable/delete_break_point.php";//Delete timetable break_points Endpoint
                exit;
            break;

    endswitch;
