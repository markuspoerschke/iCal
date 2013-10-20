# eluceo — iCal

[![Build Status](https://secure.travis-ci.org/eluceo/iCal.png)](http://travis-ci.org/eluceo/iCal)

This package offers a abstraction layer for creating iCalendars. The output will 
follow [RFC 2445](http://www.ietf.org/rfc/rfc2445.txt) as best as possible.

The following components are supported at this time:

* VCALENDAR
* VEVENT

## Installation

You can install this package by using [Composer](http://getcomposer.org). 
Link to Packagist: https://packagist.org/packages/eluceo/ical

```
{
    "require": {
        "eluceo/ical": "*"
    }
}
```

## Usage

### Basic Usage

#### 1. Create a Calendar object

```PHP
$vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');
```

#### 2. Create an Event object

```PHP
$vEvent = new \Eluceo\iCal\Component\Event();
```

#### 3. Add your information to the Event

```PHP
$vEvent->setDtStart(new \DateTime('2012-12-24'));
$vEvent->setDtEnd(new \DateTime('2012-12-24'));
$vEvent->setNoTime(true);
$vEvent->setSummary('Christmas');
```

#### 4. Add Event to Calendar

```PHP
$vCalendar->addEvent($vEvent);
```

#### 5. Set HTTP-headers

```PHP
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');
```

#### 6. Send output

```PHP
echo $vCalendar->render();
```

### Timezone support

This package supports three different types of handling timezones:

#### 1. UTC (default)

In the default setting, UTC/GMT will be used as Timezone. The time will be formated as following:

```
DTSTART:20121224T180000Z
```

#### 2. Use explicit timezone

You can use an explicit timezone by calling `$vEvent->setUseTimezone(true);`. The timezone of your 
`\DateTime` object will be used. The output will be as following:

```
DTSTART;TZID=Europe/Berlin:20121224T180000
```

#### 3. Use locale time

You can use local time by calling `$vEvent->setUseUtc(false);`. The output will be:

```
DTSTART:20121224T180000
```

## Running the tests

To setup and run tests:

- go to the root directory of this project
- download composer: `wget https://getcomposer.org/composer.phar`
- install dev dependencies: `php composer.phar install --dev`
- run `./vendor/bin/phpunit -c tests`

## License

This package is released under the __MIT license__.

Copyright (c) 2012-2013 Markus Poerschke

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
