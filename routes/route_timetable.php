<?php
    switch($request):
        case "timetable/add"://add entry route
                include_once "api/timetable/add_entry.php";//Add entry Endpoint
                exit;
            break;

        case "timetable/edit"://edit timetable route
                include_once "api/timetable/edit_timetable.php";//Edit timetable Endpoint
                exit;
            break;

        case "timetable/get"://get timetable route
                include_once "api/timetable/get_timetable.php";//Get timetable Endpoint
                exit;
            break;

        case "timetable/delete"://delete timetable route
                include_once "api/timetable/delete_entry.php";//Delete timetable Endpoint
                exit;
            break;

    endswitch;
