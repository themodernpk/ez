<?php

class Dates
{


    public static function showTimeAgo($date)
    {
        if (empty($date)) {
            return "No date provided";
        }
        $periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        $now = time();
        $unix_date = strtotime($date);
        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }
        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }
        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j] .= "s";
        }
        return "$difference $periods[$j] {$tense}";
    }

    //-----------------------------------------------------------------
    public static function dateformat($datetime, $day = false, $format = NULL)
    {
        if ($datetime == "0000-00-00 00:00:00") {
            return false;
        }
        $unix_date = strtotime($datetime);
        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }
        if ($format != NULL) {
            $d = date_create($datetime);
            $formitted = date_format($d, $format);
            return $formitted;
        }
        $count = strlen($datetime);
        if ($count == 10) {
            $date = $datetime;
            $time = "";
        } else if ($count > 10) {
            $datetime_d = explode(" ", $datetime);
            $date = $datetime_d[0];
            if (isset($datetime_d[1])) {
                $time = $datetime_d[1];
            }
        }
        if ($day == true) {
            $format = "l jS F Y";
        }
        if ($format == NULL) {
            $format = "M j, Y";
        }
        if (isset($time) && $time != "") {
            $format .= " g:i:s A";
        }
        $d = date_create($datetime);
        $formitted = date_format($d, $format);
        return $formitted;
    }

    //-----------------------------------------------------------------
    public static function now()
    {
        return date('Y-m-d H:i:s');
    }
    //-----------------------------------------------------------------
    public static function getWorkingDays($startDate,$endDate,$holidays)
    {
        $debug = false;
        $work = 0;
        $nowork = 0;
        $dayx = strtotime($startDate);
        $endx = strtotime($endDate);
        if($debug){
            echo '<h1>get_working_days</h1>';
            echo 'startDate: '.date('r',strtotime( $startDate)).'<br>';
            echo 'endDate: '.date('r',strtotime( $endDate)).'<br>';
            var_dump($holidays);
            echo '<p>Go to work...';
        }


        $result = array();
        $result['working_days'] = "";

        while($dayx <= $endx){
            $day = date('N',$dayx);
            $date = date('Y-m-d',$dayx);



            if($debug)echo '<br />'.date('r',$dayx).' ';
            if($day > 6 || in_array($date, $holidays))
            {
                $nowork++;
                if($debug){
                    if($day > 6){
                        echo 'weekend';
                    }else
                    {
                        echo 'holiday';
                    }
                }
            } else
            {
                $work++;
                $result['working_days'][] = $date;
            }
            $dayx = strtotime($date.' +1 day');
        }
        if($debug){
            echo '<p>No work: '.$nowork.'<br>';
            echo 'Work: '.$work.'<br>';
            echo 'Work + no work: '.($nowork+$work).'<br>';
            echo 'All seconds / seconds in a day: '.floatval(strtotime($endDate)-strtotime($startDate))/floatval(24*60*60);
        }

        //return $work;
        return $result;
    }
    //-----------------------------------------------------------------
    public static function getFirstAndLastDay($month, $year)
    {
        $first = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        $last = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));

        $result['first'] = $first;
        $result['last'] = $last;

        return $result;
    }
    //-----------------------------------------------------------------
    public static function getFirstAndCurrentDay()
    {
        $first = date('Y-m-01');
        $last = date('Y-m-d');

        $result['first'] = $first;
        $result['last'] = $last;

        return $result;
    }
    //-----------------------------------------------------------------
    public static function countDaysBetweenDates($start, $end)
    {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }
    //-----------------------------------------------------------------
    public static function getDaysBetweenDates($start, $end)
    {
        // Vars
        $day = 86400; // Day in seconds
        $format = 'Y-m-d'; // Output format (see PHP date funciton)
        $sTime = strtotime($start); // Start as time
        $eTime = strtotime($end); // End as time
        $numDays = round(($eTime - $sTime) / $day) + 1;
        $days = array();

        // Get days
        for ($d = 0; $d < $numDays; $d++) {
            $days[] = date($format, ($sTime + ($d * $day)));
        }

        // Return days
        return $days;
    }

    //-----------------------------------------------------------------
    public static function getMonthsBetweenDates($start, $end)
    {
        $start    = new DateTime($start);
        $start->modify('first day of this month');
        $end      = new DateTime($end);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $result = array();
        foreach ($period as $dt) {
            $result[] = $dt->format("Y-m");
        }

        return $result;
    }
    //-----------------------------------------------------------------
    public static function compareDates($date1,$date2)
    {
        $date1_array = explode("-",$date1);
        $date2_array = explode("-",$date2);
        $timestamp1 =
            mktime(0,0,0,$date1_array[1],$date1_array[2],$date1_array[0]);
        $timestamp2 =
            mktime(0,0,0,$date2_array[1],$date2_array[2],$date2_array[0]);
        if ($timestamp1>$timestamp2) {
            //print "The second date is earlier than the first.";
            return 1;
        } else if ($timestamp1<$timestamp2) {
            //print "The first date is earlier than the second.";
            return 2;
        } else {
            //print "The dates are equal.";
            return 0;
        }
    }
    //-----------------------------------------------------------------
    public static function getMinutesBetweenDates($start, $end)
    {
        $datetime1 = strtotime($start);
        $datetime2 = strtotime($end);
        $interval  = abs($datetime2 - $datetime1);
        $minutes   = round($interval / 60);
        return $minutes;
    }
    //-----------------------------------------------------------------
    public static function getSecondsBetweenDates($start, $end)
    {
        $timeFirst  = strtotime($start);
        $timeSecond = strtotime($end);
        $differenceInSeconds = $timeSecond - $timeFirst;
        return $differenceInSeconds;
    }
    //-----------------------------------------------------------------
    public static function getHoursBetweenDates($start, $end)
    {
        $time_difference = Dates::getTimeDifferenceBetweenDates($start, $end);

        if(isset($time_difference['hour']))
        {
            return $time_difference['hour'];
        } else if(isset($time_difference['hours']))
        {
            return $time_difference['hours'];
        } else
        {
            return 0;
        }

    }
    //-----------------------------------------------------------------
    public static function getTimeDifferenceBetweenDates($time1, $time2, $precision = 6)
    {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year','month','day','hour','minute','second');
        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval)
        {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1) {
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[$interval] = $value;
                $count++;
            }
        }

        return $times;
    }
    //-----------------------------------------------------------------
    public static function getTimeDifferenceInHHMMSS($start, $end)
    {
        $time_difference = Dates::getTimeDifferenceBetweenDates($start, $end);

        $result = "";

        if(isset($time_difference['hour']))
        {
            $result .= $time_difference['hour'].":";
        } else if(isset($time_difference['hours']))
        {
            $result .= $time_difference['hours'].":";
        } else
        {
            $result .= "00:";
        }

        if(isset($time_difference['minute']))
        {
            $result .= $time_difference['minute'].":";
        } else if(isset($time_difference['minutes']))
        {
            $result .= $time_difference['minutes'].":";
        } else
        {
            $result .= "00:";
        }

        if(isset($time_difference['second']))
        {
            $result .= $time_difference['second'];
        } else if(isset($time_difference['seconds']))
        {
            $result .= $time_difference['seconds'];
        } else
        {
            $result .= "00";
        }

        return $result;

    }
    //-----------------------------------------------------------------
    public static function sum_the_time($time1, $time2)
    {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time)
        {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        return "{$hours}:{$minutes}:{$seconds}";
    }
    //-----------------------------------------------------------------
    public static function subtract_the_time($start_time, $end_time)
    {

        list($hours, $minutes) = explode(':', $start_time);
        $startTimestamp = mktime($hours, $minutes);

        list($hours, $minutes) = explode(':', $end_time);
        $endTimestamp = mktime($hours, $minutes);

        $seconds = $endTimestamp - $startTimestamp;

        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;

        return "{$hours}:{$minutes}:{$seconds}";
    }
    //-----------------------------------------------------------------
    public static function getDaysInMonth($month=NULL, $year=NULL)
    {
        if($month == NULL)
        {
            $month = date('m');
        }

        if($year == NULL)
        {
            $year = date('Y');
        }

        $numDays = cal_days_in_month (CAL_GREGORIAN, $month, $year);
        return $numDays;
    }
    //-----------------------------------------------------------------
    //-----------------------------------------------------------------
    //-----------------------------------------------------------------
    //-----------------------------------------------------------------


} //end of class