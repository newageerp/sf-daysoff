<?php

namespace Newageerp\DaysOff;

use DateTime;

class Daysoff
{
    protected $holidays = [];

    public function __construct()
    {
        $this->holidays = json_decode(
            file_get_contents(
                dirname(__DIR__) . '/assets/holidayDates.json'
            ),
            true
        );
    }

    public function isDayOff(DateTime $date): bool
    {
        return $this->isSaturday($date) || $this->isSunday($date) || $this->isHoliday($date);
    }

    public function isSaturday(DateTime $date): bool
    {
        return $date->format('w') === '6';
    }

    public function isSunday(DateTime $date): bool
    {
        return $date->format('w') === '0';
    }

    public function isHoliday(DateTime $date): bool
    {
        return in_array(
            $date->format('Y-m-d'),
            $this->holidays
        );
    }

    public function isWorkingDay(DateTime $date): bool
    {
        return !$this->isDayOff($date);
    }

    public function nextWorkingDay(DateTime $date): DateTime
    {
        $d = clone $date;

        $isWorkingDay = false;
        while (!$isWorkingDay) {
            $d->add(new \DateInterval('P1D'));
            $isWorkingDay = $this->isWorkingDay($d);
        }
        return $d;
    }

    public function prevWorkingDay(DateTime $date): DateTime
    {
        $d = clone $date;

        $isWorkingDay = false;
        while (!$isWorkingDay) {
            $d->sub(new \DateInterval('P1D'));
            $isWorkingDay = $this->isWorkingDay($d);
        }
        return $d;
    }
}