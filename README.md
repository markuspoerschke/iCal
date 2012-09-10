# eluceo — iCal
This package offers PHP-classes to create iCal compatible *.ics files.

## Usage

### 1. Create a Calendar object

```PHP
$vCalendar = new \Eluceo\iCal\Component\Calendar('www.example.com');
```

### 2. Create an Event object

```PHP
$vEvent = new \Eluceo\iCal\Component\Event();
```

### 3. Add your information to the Event

```PHP
$vEvent->setDtStart(new \DateTime('2012-12-24'));
$vEvent->setDtEnd(new \DateTime('2012-12-24'));
$vEvent->setNoTime(true);
$vEvent->setSummary('Christmas');
```

### 4. Add Event to Calendar

```PHP
$vCalendar->addEvent($vEvent);
```

### 5. Set HTTP-headers

```PHP
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');
```

### 6. Send output

```PHP
echo $vCalendar->render();
```