---
title: Maturity Matrix
---

The generation of the `.ics` file follows the “Internet Calendaring and Scheduling Core Object
Specification” ([RFC 5545](https://tools.ietf.org/html/rfc5545)). The domain objects in this package do not fully
support all possibilities, that the specification provides. The following tables give an overview about the supported
features.

In the compatibility matrix, the icons from the following table are used. Each icon marks the level of support for the
corresponding property or component.

| Icon | Meaning             |
| :--: | ------------------- |
|  ✔   | supported           |
|  ✖   | not supported       |
| (✔)  | partially supported |

## Components

See [RFC 5545 section 3.6](https://tools.ietf.org/html/rfc5545#section-3.6).

| Component | Supported |
| --------- | :-------: |
| VEVENT    |     ✔     |
| VTODO     |     ✖     |
| VJOURNAL  |     ✖     |
| VFREEBUSY |     ✖     |
| VTIMEZONE |    (✔)    |
| VALARM    |     ✔     |

## Event Component

See [RFC 5545 section 3.6.1](https://tools.ietf.org/html/rfc5545#section-3.6.1).

| Property                    | Supported |
| --------------------------- | :-------: |
| dtstamp                     |     ✔     |
| uid                         |     ✔     |
| dtstart                     |     ✔     |
| class                       |     ✖     |
| created                     |     ✖     |
| description                 |     ✔     |
| geo                         |     ✔     |
| last-mod                    |     ✔     |
| location                    |     ✔     |
| organizer                   |     ✔     |
| priority                    |     ✖     |
| seq                         |     ✖     |
| status                      |     ✖     |
| summary                     |     ✔     |
| transp                      |     ✖     |
| url                         |     ✔     |
| recurid                     |     ✖     |
| rrule                       |     ✖     |
| dtend                       |     ✔     |
| duration                    |     ✖     |
| attach                      |     ✔     |
| attendee                    |     ✖     |
| categories                  |     ✖     |
| comment                     |     ✖     |
| contact                     |     ✖     |
| exdate                      |     ✖     |
| rstatus                     |     ✖     |
| related                     |     ✖     |
| resources                   |     ✖     |
| rdate                       |     ✖     |
| x-prop                      |    (✔)    |
| iana-prop                   |    (✔)    |
| x-apple-structured-location |     ✔     |

## Alarm Component

See [RFC 5545 section 3.6.1](https://tools.ietf.org/html/rfc5545#section-3.6.1).

### Audio

| Property  | Supported |
| --------- | :-------: |
| action    |     ✔     |
| trigger   |     ✔     |
| duration  |     ✔     |
| repeat    |     ✔     |
| attach    |     ✖     |
| x-prop    |    (✔)    |
| iana-prop |    (✔)    |

### Display

| Property    | Supported |
| ----------- | :-------: |
| action      |     ✔     |
| trigger     |     ✔     |
| description |     ✔     |
| duration    |     ✔     |
| repeat      |     ✔     |
| x-prop      |    (✔)    |
| iana-prop   |    (✔)    |

### Email

Not yet supported.

## Time Zone Component

See [RFC 5545 section 3.6.5](https://tools.ietf.org/html/rfc5545#section-3.6.5).

| Property  | Supported |
| --------- | :-------: |
| tzid      |     ✔     |
| last-mod  |     ✖     |
| tzurl     |     ✖     |
| x-prop    |    (✔)    |
| iana-prop |    (✔)    |

### Standard / Daylight sub-component

| Property     | Supported |
| ------------ | :-------: |
| dtstart      |     ✔     |
| tzoffsetto   |     ✔     |
| tzoffsetfrom |     ✔     |
| rrule        |     ✖     |
| comment      |     ✖     |
| rdate        |     ✖     |
| tzname       |     ✔     |
| x-prop       |    (✔)    |
| iana-prop    |    (✔)    |
