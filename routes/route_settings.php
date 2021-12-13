<?php
    switch($request):
        case "timetable/settings/add"://add settings route
                include_once "api/timetable/add_settings.php";//Add settings Endpoint
                exit;
            break;

        case "timetable/settings/edit"://edit timetable settings route
                include_once "api/timetable/edit_settings.php";//Edit timetable settings Endpoint
                exit;
            break;

        case "timetable/settings/get"://get timetable settings route
                include_once "api/timetable/get_settings.php";//Get timetable settings Endpoint
                exit;
            break;

        case "timetable/settings/delete"://delete timetable settings route
                include_once "api/timetable/delete_settings.php";//Delete timetable settings Endpoint
                exit;
            break;

    endswitch;
