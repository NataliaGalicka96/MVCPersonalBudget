<?php

namespace App;

class Date

{
   
    public static function getCurrentDate()
    {
        return date('Y-m-d');
    }
    
    public static function getFirstDayOfCurrentMonth()
    {
        
        return date('Y-m-01');
    }
    
    public static function getLastDayOfCurrentMonth()
    {
        return date('Y-m-t');
    }
    
    public static function getFirstDayOfPreviousMonth()
    {
        return date('Y-m-d', strtotime('first day of last month'));
    }
    
    public static function getlastDayOfPreviousMonth()
    {
        return date('Y-m-d', strtotime('last day of last month')); 
    }
    
}