<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class DaysOffTest extends TestCase
{
    /**
     * @dataProvider workingDaysProvider
     */
    public function testWorkingDays(\DateTime $d, bool $expected): void
    {
        $daysOff = new \Newageerp\DaysOff\Daysoff();

        $this->assertSame($daysOff->isWorkingDay($d), $expected);
    }

    /**
     * @dataProvider nextWorkingDaysProvider
     */
    public function testNextWorkingDays(\DateTime $d, \DateTime $expected): void
    {
        $daysOff = new \Newageerp\DaysOff\Daysoff();

        $this->assertSame($daysOff->nextWorkingDay($d)->format('Ymd'), $expected->format('Ymd'));
    }

    /**
     * @dataProvider prevWorkingDaysProvider
     */
    public function testPrevWorkingDays(\DateTime $d, \DateTime $expected): void
    {
        $daysOff = new \Newageerp\DaysOff\Daysoff();

        $this->assertSame($daysOff->prevWorkingDay($d)->format('Ymd'), $expected->format('Ymd'));
    }

    public function prevWorkingDaysProvider(): array
    {
        return [
            [new \DateTime('2021-01-01'), new \DateTime('2020-12-31')],
            [new \DateTime('2022-07-23'), new \DateTime('2022-07-22')],
            [new \DateTime('2022-07-22'), new \DateTime('2022-07-21')],
            [new \DateTime('2022-07-25'), new \DateTime('2022-07-22')],
        ];
    }

    public function nextWorkingDaysProvider(): array
    {
        return [
            [new \DateTime('2021-01-01'), new \DateTime('2021-01-04')],
            [new \DateTime('2022-07-23'), new \DateTime('2022-07-25')],
            [new \DateTime('2022-07-22'), new \DateTime('2022-07-25')],
            [new \DateTime('2022-07-20'), new \DateTime('2022-07-21')],
        ];
    }

    public function workingDaysProvider(): array
    {
        return [
            [new \DateTime('2021-01-01'), false],
            [new \DateTime('2022-07-23'), false],
            [new \DateTime('2022-07-22'), true],
            [new \DateTime('2022-07-15'), true],
        ];
    }
}