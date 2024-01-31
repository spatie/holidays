<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use RuntimeException;

class Tunisia extends Country
{
    private array $hijriHolidays = [
        "1970" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1969-12-11",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1969-12-12",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1970-02-17",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1970-02-18",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1970-03-08",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1970-05-17",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1971" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1970-11-30",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1970-12-01",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1971-02-06",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1971-02-07",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1971-02-26",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1971-05-07",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1972" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1971-11-20",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1971-11-21",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1972-01-27",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1972-01-28",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1972-02-15",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1972-04-25",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1973" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1972-11-08",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1972-11-09",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1973-01-15",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1973-01-16",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1973-02-03",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1973-04-14",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1974" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1973-10-28",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1973-10-29",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1974-01-04",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1974-01-05",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1974-01-24",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1974-04-04",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1975" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1974-10-18",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1974-10-19",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1974-12-25",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1974-12-26",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1975-01-13",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1975-03-24",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1976" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1975-10-07",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1975-10-08",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1975-12-14",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1975-12-15",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1976-12-22",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1977-03-02",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1977" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1977-09-15",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1977-09-16",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1977-11-22",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1977-11-23",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1977-12-11",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1978-02-19",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1978" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1978-09-04",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1978-09-05",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1978-11-11",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1978-11-12",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1978-12-01",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1979-02-09",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1979" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1979-08-25",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1979-08-26",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1979-11-01",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1979-11-02",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1979-11-20",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1980-01-29",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1980" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1980-08-13",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1980-08-14",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1980-10-20",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1980-10-21",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1980-11-08",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1981-01-17",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1981" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1981-08-02",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1981-08-03",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1981-10-09",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1981-10-10",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1981-10-29",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1982-01-07",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1982" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1982-07-23",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1982-07-24",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1982-09-29",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1982-09-30",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1982-10-18",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1982-12-27",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1983" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1983-07-12",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1983-07-13",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1983-09-18",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1983-09-19",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1983-10-07",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1983-12-16",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1984" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1984-06-30",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1984-07-01",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1984-09-06",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1984-09-07",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1984-09-26",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1984-12-05",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1985" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1985-06-20",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1985-06-21",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1985-08-27",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1985-08-28",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1985-09-15",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1985-11-24",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1986" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1986-06-09",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1986-06-10",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1986-08-16",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1986-08-17",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1986-09-05",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1986-11-14",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1987" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1987-05-30",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1987-05-31",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1987-08-06",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1987-08-07",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1987-08-25",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1987-11-03",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1988" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1988-05-18",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1988-05-19",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1988-07-25",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1988-07-26",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1988-08-13",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1988-10-22",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1989" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1989-05-07",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1989-05-08",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1989-07-14",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1989-07-15",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1989-08-03",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1989-10-12",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1990" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1990-04-27",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1990-04-28",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1990-07-04",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1990-07-05",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1990-07-23",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1990-10-01",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1991" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1991-04-16",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1991-04-17",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1991-06-23",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1991-06-24",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1991-07-12",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1991-09-20",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1992" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1992-04-04",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1992-04-05",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1992-06-11",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1992-06-12",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1992-07-01",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1992-09-09",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1993" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1993-03-25",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1993-03-26",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1993-06-01",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1993-06-02",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1993-06-20",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1993-08-29",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1994" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1994-03-14",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1994-03-15",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1994-05-21",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1994-05-22",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1994-06-09",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1994-08-18",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1995" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1995-03-03",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1995-03-04",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1995-05-10",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1995-05-11",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1995-05-30",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1995-08-08",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1996" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1996-02-21",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1996-02-22",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1996-04-29",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1996-04-30",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1996-05-18",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1996-07-27",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1997" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1997-02-09",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1997-02-10",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1997-04-18",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1997-04-19",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1997-05-08",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1997-07-17",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1998" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1998-01-30",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1998-01-31",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1998-04-08",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1998-04-09",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1998-04-27",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1998-07-06",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "1999" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "1999-01-19",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "1999-01-20",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "1999-03-28",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "1999-03-29",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "1999-04-16",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "1999-06-25",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2000" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2000-01-08",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2000-01-09",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2000-03-16",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2000-03-17",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2000-04-05",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2000-06-14",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2001" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2000-12-28",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2000-12-29",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2001-03-06",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2001-03-07",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2001-03-25",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2001-06-03",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2002" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2001-12-17",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2001-12-18",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2002-02-23",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2002-02-24",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2002-03-14",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2002-05-23",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2003" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2002-12-06",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2002-12-07",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2003-02-12",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2003-02-13",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2003-03-04",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2003-05-13",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2004" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2003-11-26",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2003-11-27",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2004-02-02",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2004-02-03",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2004-02-21",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2004-05-01",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2005" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2004-11-14",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2004-11-15",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2005-01-21",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2005-01-22",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2005-02-09",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2005-04-20",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2006" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2005-11-03",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2005-11-04",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2006-01-10",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2006-01-11",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2006-01-30",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2006-04-10",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2007" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2006-10-24",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2006-10-25",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2006-12-31",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2007-01-01",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2007-01-19",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2007-03-30",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2008" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2007-10-13",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2007-10-14",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2007-12-20",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2007-12-21",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2008-12-28",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2009-03-08",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2009" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2009-09-21",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2009-09-22",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2009-11-28",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2009-11-29",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2009-12-17",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2010-02-25",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2010" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2010-09-10",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2010-09-11",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2010-11-17",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2010-11-18",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2010-12-07",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2011-02-15",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2011" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2011-08-31",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2011-09-01",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2011-11-07",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2011-11-08",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2011-11-26",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2012-02-04",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2012" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2012-08-19",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2012-08-20",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2012-10-26",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2012-10-27",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2012-11-14",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2013-01-23",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2013" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2013-08-08",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2013-08-09",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2013-10-15",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2013-10-16",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2013-11-04",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2014-01-13",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2014" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2014-07-29",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2014-07-30",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2014-10-05",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2014-10-06",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2014-10-24",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2015-01-02",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2015" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2015-07-18",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2015-07-19",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2015-09-24",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2015-09-25",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2015-10-14",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2015-12-23",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2016" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2016-07-07",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2016-07-08",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2016-09-13",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2016-09-14",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2016-10-02",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2016-12-11",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2017" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2017-06-26",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2017-06-27",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2017-09-02",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2017-09-03",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2017-09-21",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2017-11-30",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2018" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2018-06-15",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2018-06-16",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2018-08-22",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2018-08-23",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2018-09-11",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2018-11-20",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2019" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2019-06-05",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2019-06-06",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2019-08-12",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2019-08-13",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2019-08-31",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2019-11-09",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2020" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2020-05-24",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2020-05-25",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2020-07-31",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2020-08-01",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2020-08-19",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2020-10-28",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2021" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2021-05-13",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2021-05-14",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2021-07-20",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2021-07-21",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2021-08-09",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2021-10-18",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2022" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2022-05-03",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2022-05-04",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2022-07-10",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2022-07-11",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2022-07-29",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2022-10-07",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2023" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2023-04-22",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2023-04-23",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2023-06-29",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2023-06-30",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2023-07-18",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2023-09-26",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2024" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2024-04-10",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2024-04-11",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2024-06-17",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2024-06-18",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2024-07-07",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2024-09-15",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2025" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2025-03-31",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2025-04-01",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2025-06-07",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2025-06-08",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2025-06-26",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2025-09-04",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2026" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2026-03-20",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2026-03-21",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2026-05-27",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2026-05-28",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2026-06-16",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2026-08-25",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2027" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2027-03-10",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2027-03-11",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2027-05-17",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2027-05-18",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2027-06-05",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2027-08-14",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2028" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2028-02-27",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2028-02-28",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2028-05-05",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2028-05-06",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2028-05-24",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2028-08-02",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2029" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2029-02-15",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2029-02-16",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2029-04-24",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2029-04-25",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2029-05-14",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2029-07-23",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2030" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2030-02-05",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2030-02-06",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2030-04-14",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2030-04-15",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2030-05-03",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2030-07-12",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2031" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2031-01-25",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2031-01-26",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2031-04-03",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2031-04-04",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2031-04-22",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2031-07-01",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2032" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2032-01-14",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2032-01-15",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2032-03-22",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2032-03-23",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2032-04-11",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2032-06-20",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2033" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2033-01-03",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2033-01-04",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2033-03-12",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2033-03-13",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2033-03-31",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2033-06-09",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2034" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2033-12-23",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2033-12-24",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2034-03-01",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2034-03-02",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2034-03-20",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2034-05-29",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2035" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2034-12-12",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2034-12-13",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2035-02-18",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2035-02-19",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2035-03-10",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2035-05-19",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2036" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2035-12-02",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2035-12-03",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2036-02-08",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2036-02-09",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2036-02-27",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2036-05-07",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
        "2037" => [
            [
                "name" => "Eid al-Fitr",
                "date" => "2036-11-20",
                "slug" => "eid-al-fitr",
            ],
            [
                "name" => "Eid al-Fitr - 2nd day",
                "date" => "2036-11-21",
                "slug" => "eid-al-fitr---2nd-day",
            ],
            [
                "name" => "Eid al-Adha",
                "date" => "2037-01-27",
                "slug" => "eid-al-adha",
            ],
            [
                "name" => "Eid al-Adha - 2nd day",
                "date" => "2037-01-28",
                "slug" => "eid-al-adha---2nd-day",
            ],
            [
                "name" => "Islamic new year",
                "date" => "2037-02-16",
                "slug" => "islamic-new-year",
            ],
            [
                "name" => "Birthday of the Prophet Muhammad",
                "date" => "2037-04-27",
                "slug" => "birthday-of-the-prophet-muhammad",
            ],
        ],
    ];

    /**
     * @return string
     */
    public function countryCode(): string
    {
        return 'tn';
    }

    /**
     * @param int $year
     * @return array|CarbonImmutable[]|string[]
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Independence Day' => '03-20',
            'Martyrs\' Day' => '04-09',
            'Labour Day' => '05-01',
            'Republic Day' => '07-25',
            'Women\'s Day' => '08-13',
            'Evacuation Day' => '10-15',
            'Revolution and Youth Day' => '12-17',
        ], $this->variableHolidays($year));
    }

    /**
     * The following holidays are considered public holidays in Tunisia. However, their dates vary each year,
     * as they are based on the Islamic Hijri (lunar) calendar. These holidays do not have a fixed date and
     * occur based on the lunar calendar sequence. The order listed reflects the chronological occurrence
     * of these holidays throughout the year.
     * @param int $year
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        return [
            'Islamic new year' => $this->getIslamicHoliday($year, 'islamic-new-year'),
            'Birthday of the Prophet Muhammad' => $this->getIslamicHoliday($year, 'birthday-of-the-prophet-muhammad'),
            'Eid al-Fitr' => $this->getIslamicHoliday($year, 'eid-al-fitr'),
            'Eid al-Fitr - 2nd day' => $this->getIslamicHoliday($year, 'eid-al-fitr---2nd-day'),
            'Eid al-Adha' => $this->getIslamicHoliday($year, 'eid-al-adha'),
            'Eid al-Adha - 2nd day' => $this->getIslamicHoliday($year, 'eid-al-adha---2nd-day'),
        ];
    }

    /**
     * @param int $year
     * @param string $slug
     * @return bool|CarbonImmutable
     */
    protected function getIslamicHoliday(int $year, string $slug): bool|CarbonImmutable
    {
        $found = self::searchSubArray($this->hijriHolidays[$year], $slug);
        if (count($found)) {
            return CarbonImmutable::createFromFormat('Y-m-d', $found['date']);
        }
        throw new RuntimeException('Date not found.');
    }

    /**
     * @param array $array
     * @param $value
     * @return array
     */
    private static function searchSubArray(array $array, $value): array
    {
        foreach ($array as $subarray) {
            if (isset($subarray['slug']) && $subarray['slug'] == $value)
                return (array)$subarray;
        }
        return [];
    }

}
