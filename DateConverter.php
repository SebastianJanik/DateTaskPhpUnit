<?php

class DateConverter
{
    private string|false $string;
    private array $numsArray;
    private array $perms;
    private array $dates;
    private string $invalidDate;

    public function __construct($string = null)
    {
        if (!$string)
            $string = file_get_contents('./input.txt');
        $this->string = $string;
        $this->numsArray = explode('/', $this->string);
        $this->perms = array();
        $this->dates = array();
        $this->invalidDate = "Date is invalid";
        $this->permutations($this->numsArray);
        $this->createDates();
    }

    public function permutations($array, $perms = array())
    {
        if (empty($array)) {
            $this->perms [] = $perms;
        } else {
            for ($i = count($array) - 1; $i >= 0; --$i) {
                $newitems = $array;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->permutations($newitems, $newperms);
            }
        }
    }

    public function createDates()
    {
        foreach ($this->perms as $item) {
            $year = $item[0];
            if (strlen($year) < 4) {
                $year += 2000;
            }
            $month = $item[1];
            if ($month == '0') {
                $month = 1;
            }
            $day = $item[2];
            if ($day == '0') {
                $day = 1;
            }
            if (checkdate($month, $day, $year)) {
//                $this->dates [] = DateTime::createFromFormat('Y-m-d', $year.'-'.$month.'-'.$day);
                $this->dates [] = date('Y-m-d', strtotime($year . '-' . $month . '-' . $day));
            }
        }
    }

    private static function dateSort($a, $b) {
        return strtotime($a) - strtotime($b);
    }

    public function getEarliestDate() : string
    {
        if (empty($this->dates))
            return $this->invalidDate;

        usort($this->dates, array("DateConverter", "dateSort"));
        return $this->dates[0];
    }

    public function getDates() : array
    {
        return $this->dates;
    }

    public function getInvalidDateMessage() : string
    {
        return $this->invalidDate;
    }
}
$obj = new DateConverter();
//var_dump($obj->getDates());
var_dump($obj->getEarliestDate());
