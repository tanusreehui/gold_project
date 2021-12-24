<?php
//https://laravel-news.com/creating-helpers
//composer dump-autoload

use Carbon\Carbon;

if (! function_exists('get_sql_with_bindings')) {
    function get_sql_with_bindings($query) {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }
}


if (! function_exists('get_age')) {
    function get_age($dateOfBirth) {
        return Carbon::parse($dateOfBirth)->age;
    }
}

if (! function_exists('get_accounting_year')) {
    function get_accounting_year($entry_date = "") {
        if($entry_date == ""){
            $entry_date = Carbon::now()->format('Y-m-d');
        }
        $temp_date = explode("-",$entry_date);
        if($temp_date[1]>3){
            $x = $temp_date[0]%100;
            $accounting_year = $x*100 + ($x+1);
        }else{
            $x = $temp_date[0]%100;
            $accounting_year =($x-1)*100+$x;
        }
        return $accounting_year;
    }
}
if (! function_exists('get_next_year')) {
    function get_next_year($current_year,$current_month) {
        $next_year = $current_year;
        $next_month = $current_month+1;
        if($next_month>12){
            $next_year=$next_year+1;
            $next_month=1;
        }
        return $next_year;
    }
}
if (! function_exists('get_next_month')) {
    function get_next_month($current_year,$current_month) {
        $next_year = $current_year;
        $next_month = $current_month+1;
        if($next_month>12){
            $next_year=$next_year+1;
            $next_month=1;
        }
        return $next_month;
    }
}

if (! function_exists('get_short_name')) {
    function get_short_name($name) {
        $pieces = explode(" ", $name);
        $x="";
        $y="";
        if(count($pieces)==1){
            $x = substr($pieces[0],0,2); // piece1
        }
        if(count($pieces)>1){
            $x = substr($pieces[0],0,2); // piece1
            $y = substr($pieces[1],0,2); // piece1
        }

        return $x.$y;
    }
}

if (! function_exists('changeDateFormUTCtoLocal')) {
    function changeDateFormUTCtoLocal($date) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }
}

if (! function_exists('generateJobTag')) {
    function generateJobTag($jobNumber) {
        $arr = explode('-',$jobNumber);
        $yearCodes=array('2122'=>'A',
            '2223'=>'B',
            '2324'=>'C',
            '2425'=>'D',
            '2526'=>'E',
            '2627'=>'F',
            '2728'=>'G',
            '2829'=>'H',
            '2930'=>'I',
            '3031'=>'J',
            '3132'=>'K',
            '3233'=>'A',
            '3334'=>'B',
            '3435'=>'C',
            '3536'=>'D',
            '3637'=>'E',
            '3738'=>'F',
            '3839'=>'G',
            '3940'=>'H',
            '4041'=>'I',
            '4142'=>'J',
            '4243'=>'K',
            );
        $jobMiddle = str_pad((int)$arr[1], 4, '0', STR_PAD_LEFT);
        return $yearCodes[$arr[2]].$jobMiddle;
    }
}






