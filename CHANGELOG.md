# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.14.0] - 2024-07-11

### Fixed

-   Fix \\n being escaped to \\n, leading to no newlines in actual text [#617](https://github.com/markuspoerschke/iCal/pull/617)

## [2.13.0] - 2023-12-19

### Added

-   Support PHP 8.3 [#576](https://github.com/markuspoerschke/iCal/pull/576)

## [2.12.1] - 2023-06-22

### Fixed

-   Add value type DATE to DTSTART and DTEND [#519](https://github.com/markuspoerschke/iCal/pull/519)

## [2.12.0] - 2023-04-10

### Changed

-   Update `.gitattributes` file to exclude unnecessary files when fetching package through Composer. [#510](https://github.com/markuspoerschke/iCal/pull/510)

## [2.11.0] - 2023-01-17

### Changed

-   Declare `CalendarFactory::getProperties` protected i/o private to open it for extension [#386](https://github.com/markuspoerschke/iCal/pull/386)

## [2.10.0] - 2023-01-17

### Fixed

-   Fix formatting date time property with UTC time zone [#482](https://github.com/markuspoerschke/iCal/pull/482)

## [2.9.0] - 2022-12-23

### Changed

-   Add missing return types and missing template annotations [#472](https://github.com/markuspoerschke/iCal/pull/472)
    -   Added `@implements IteratorAggregate<Event>` to `\Eluceo\iCal\Domain\Collection\Events`
    -   Added `@implements IteratorAggregate<ContentLine>` to `\Eluceo\iCal\Presentation\Component`
    -   Added `@return Traversable<ContentLine>` to `\Eluceo\iCal\Presentation\Component::getIterator`
-   Fix EmailAddress value object: do not url encode email addresses [#479](https://github.com/markuspoerschke/iCal/pull/479)

## [2.8.0] - 2022-12-22

### Added

-   Support chaining of `Calendar::setPublishedTTL()` [#452](https://github.com/markuspoerschke/iCal/pull/452)
-   Support PHP 8.2 [#470](https://github.com/markuspoerschke/iCal/pull/470)

## [2.7.0] - 2022-06-21

### Added

-   Support `X-PUBLISHED-TTL` property on calendars [#413](https://github.com/markuspoerschke/iCal/pull/413)

## [2.6.0] - 2022-06-17

### Added

-   Support status property on events [#422](https://github.com/markuspoerschke/iCal/pull/422)
-   Support categories property on events [#421](https://github.com/markuspoerschke/iCal/pull/421)

## [2.5.1] - 2022-04-26

### Fixed

-   Deprecation message occuring on an OOTB Symfony 5.4 on PHP 7.4 [#382](https://github.com/markuspoerschke/iCal/pull/382)

## [2.5.0] - 2022-02-13

### Added

-   Support PHP 8.1

## [2.4.0] - 2021-12-13

### Added

-   Support `symfony/deprecation-contracts` version 3 [#354](https://github.com/markuspoerschke/iCal/pull/354)
-   Event Attendee property [#333](https://github.com/markuspoerschke/iCal/pull/333)

### Fixed

-   PHPStan complains about wrongly typed hinted constructor argument of `Calendar` class. [#281](https://github.com/markuspoerschke/iCal/issues/281)

## [2.3.0] - 2021-08-24

### Added

-   Event URL property [#314](https://github.com/markuspoerschke/iCal/pull/314)
-   Event LAST-MODIFIED property [#298](https://github.com/markuspoerschke/iCal/pull/298)

## [2.2.0] - 2021-05-03

### Added

-   Event organizer [#260](https://github.com/markuspoerschke/iCal/pull/260)

## [2.1.0] - 2021-04-21

### Fixed

-   TZOFFSETTO and TZOFFSETFROM should never be -0000 [#246](https://github.com/markuspoerschke/iCal/pull/246)
-   Calling TimeZone::createFromPhpDateTimeZone with default values fails with assertion [#250](https://github.com/markuspoerschke/iCal/pull/250)

### Deprecated

-   Method `Eluceo\iCal\Domain\Entity\TimeZone::createFromPhpDateTimeZone` will not have default values
    for `$beginDateTime` and `$endDateTime` in the next major version. [#250](https://github.com/markuspoerschke/iCal/pull/250)

## [2.0.0] - 2021-03-29

This version is complete rewrite.
Please check the [upgrade guide](UPGRADE.md) on how to upgrade from version `0.*` to `2.0.0`.

### Added

-   Support for PHP 8.0.

### Changed

-   Separate domain and presentation logic

### Removed

-   Support for PHP `<=7.3`

## [0.16.0] - 2019-12-29

### Added

-   Allow to add `ATTACH` property to an event [#128](https://github.com/markuspoerschke/iCal/pull/128)
-   Support for PHP 7.4 [#141](https://github.com/markuspoerschke/iCal/pull/141)
-   Add property `X-MICROSOFT-CDO-BUSYSTATUS` [#32](https://github.com/markuspoerschke/iCal/issues/32) [#146](https://github.com/markuspoerschke/iCal/pull/146)

### Removed

-   Support for PHP 7.0 [#126](https://github.com/markuspoerschke/iCal/pull/126)

## [0.15.1] - 2019-08-06

### Fixed

-   TimeZone will be correctly applied if instance of `\DateTimeImmutable` is used [#131](https://github.com/markuspoerschke/iCal/pull/131)

## [0.15.0] - 2019-01-13

### Added

-   BYSETPOS to RecurrenceRule [#113](https://github.com/markuspoerschke/iCal/issues/113)
-   Add method `Component::setComponents(array $components)` [#124](https://github.com/markuspoerschke/iCal/issues/124)

### Changed

-   DateUtil - only convert to UTC if no timezone is specified [#123](https://github.com/markuspoerschke/iCal/issues/123)

## [0.14.0] - 2018-03-13

### Fixed

-   Properly escape `BY*` rules like `BYDAY`. [#105](https://github.com/markuspoerschke/iCal/issues/105)

## [0.13.0] - 2017-10-26

### Changed

-   Improve performance for long lines. By using mbstring the folding of lines is much faster and consumes less CPU and memory. [#103](https://github.com/markuspoerschke/iCal/pull/103)
-   In UTC mode the time will be converted to UTC timezone. [#106](https://github.com/markuspoerschke/iCal/pull/106)

## [0.12.1] - 2017-06-07

### Fixed

-   `\DateTimeImmutable` is now supported by events. When using `\DateTime` there will be no side effect anymore that will change the original date time object. [#98](https://github.com/markuspoerschke/iCal/pull/98), [#99](https://github.com/markuspoerschke/iCal/pull/99), [#100](https://github.com/markuspoerschke/iCal/pull/100)

## [0.12.0] - 2017-05-10

### Fixed

-   Do not escape value of the GEO property [#79](https://github.com/markuspoerschke/iCal/pull/79)

### Added

-   Add support for `\DateTimerInterface`. This allows to use `\DateTimeImmutable`. [#86](https://github.com/markuspoerschke/iCal/issues/86)
-   Add support for arbitrary time zone strings. [#87](https://github.com/markuspoerschke/iCal/issues/86),[#89](https://github.com/markuspoerschke/iCal/issues/86)
-   Add new Geo property class [#79](https://github.com/markuspoerschke/iCal/pull/79)

### Changed

-   Drop support for old PHP versions: 5.3, 5.4, 5.6
-   Remove default value for `X-PUBLISHED-TTL`. This value controls the update interval if the ics file is synced.
    The former default value was set to one week. If you want the behavior from version `< 0.12` you have to set the value:
    `$vCalendar->setPublishedTTL('P1W')`. [#81](https://github.com/markuspoerschke/iCal/pull/81)

### Removed

-   Remove class `\Eluceo\iCal\Property\Event\Description` [#61](https://github.com/markuspoerschke/iCal/pull/61)
-   Remove class `\Eluceo\iCal\Util\PropertyValueUtil` [#61](https://github.com/markuspoerschke/iCal/pull/61)

## [0.11.5] - 2018-03-13

### Changed

-   Convert time to UTC if UTC mode is enabled. [#111](https://github.com/markuspoerschke/iCal/issues/111)

## [0.11.4] - 2017-10-26

### Changed

-   Improve performance for long lines. By using mbstring the folding of lines is much faster and consumes less CPU and memory. [#104](https://github.com/markuspoerschke/iCal/pull/104)

## [0.11.3] - 2017-04-25

### Fixed

-   Fix the GEO property (compatibility to PHP &lt; 7) [#91](https://github.com/markuspoerschke/iCal/pull/91) [#91](https://github.com/markuspoerschke/iCal/pull/93)

## [0.11.2] - 2017-04-21

### Fixed

-   Do not escape value of the GEO property [#79](https://github.com/markuspoerschke/iCal/pull/79)

## [0.11.1] - 2017-04-04

### Fixed

-   All days events (no time) ends on the next day. [#83](https://github.com/markuspoerschke/iCal/pull/83)
-   Timezone will not applied on all days events [#83](https://github.com/markuspoerschke/iCal/pull/83)

### Added

-   Add `Event::getDtStart` method [#83](https://github.com/markuspoerschke/iCal/pull/83)

## [0.11.0] - 2016-09-16

### Added

-   Allow multiple recurrence rules in an event [#77](https://github.com/markuspoerschke/iCal/pull/77)
-   RecurrenceRule now also allows hourly, minutely and secondly frequencies [#78](https://github.com/markuspoerschke/iCal/pull/78)

### Deprecated

-   Adding a single recurrence rule to an event using `Event::setRecurrenceRule()` is deprecated and will be removed in 1.0. Use `Event::addRecurrenceRule()` instead. [#77](https://github.com/markuspoerschke/iCal/pull/77)

## [0.10.1] - 2016-05-09

### Fixed

-   Problem with GEO property when importing into Google Calendar [#74](https://github.com/markuspoerschke/iCal/pull/74)

## [0.10.0] - 2016-04-26

### Changed

-   Use 'escapeValue' to escape the new line character. [#60](https://github.com/markuspoerschke/iCal/pull/60)
-   Order components by type when building ical file. [#65](https://github.com/markuspoerschke/iCal/pull/65)

### Added

-   X-ALT-DESC for HTML types with new descriptionHTML field. [#55](https://github.com/markuspoerschke/iCal/pull/55)
-   Added a property and setter for calendar color. [#68](https://github.com/markuspoerschke/iCal/pull/68)
-   Write also GEO property if geo location is given. [#66](https://github.com/markuspoerschke/iCal/pull/66)

## [0.9.0] - 2015-11-13

### Added

-   CHANGELOG.md based on [’Keep a CHANGELOG’](https://github.com/olivierlacan/keep-a-changelog)
-   Support event properties EXDATE and RECURRENCE-ID [#50](https://github.com/markuspoerschke/iCal/pull/53)

### Changed

-   Allow new lines in event descriptions [#53](https://github.com/markuspoerschke/iCal/pull/53)
-   **Breaking Change:** Changed signature of the `Event::setOrganizer` method. Now there is is only one parameter that must be an instance of `Property\Organizer`.
-   Updated install section in README.md [#54](https://github.com/markuspoerschke/iCal/pull/53)

[Unreleased]: https://github.com/markuspoerschke/iCal/compare/2.14.0...HEAD
[2.14.0]: https://github.com/markuspoerschke/iCal/compare/2.13.0...2.14.0
[2.13.0]: https://github.com/markuspoerschke/iCal/compare/2.12.1...2.13.0
[2.12.1]: https://github.com/markuspoerschke/iCal/compare/2.12.0...2.12.1
[2.12.0]: https://github.com/markuspoerschke/iCal/compare/2.11.0...2.12.0
[2.11.0]: https://github.com/markuspoerschke/iCal/compare/2.10.0...2.11.0
[2.10.0]: https://github.com/markuspoerschke/iCal/compare/2.9.0...2.10.0
[2.9.0]: https://github.com/markuspoerschke/iCal/compare/2.8.0...2.9.0
[2.8.0]: https://github.com/markuspoerschke/iCal/compare/2.7.0...2.8.0
[2.7.0]: https://github.com/markuspoerschke/iCal/compare/2.6.0...2.7.0
[2.6.0]: https://github.com/markuspoerschke/iCal/compare/2.5.1...2.6.0
[2.5.1]: https://github.com/markuspoerschke/iCal/compare/2.5.0...2.5.1
[2.5.0]: https://github.com/markuspoerschke/iCal/compare/2.4.0...2.5.0
[2.4.0]: https://github.com/markuspoerschke/iCal/compare/2.3.0...2.4.0
[2.3.0]: https://github.com/markuspoerschke/iCal/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/markuspoerschke/iCal/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/markuspoerschke/iCal/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/markuspoerschke/iCal/compare/0.16.0...2.0.0
[0.16.0]: https://github.com/markuspoerschke/iCal/compare/0.15.1...0.16.0
[0.15.1]: https://github.com/markuspoerschke/iCal/compare/0.15.0...0.15.1
[0.15.0]: https://github.com/markuspoerschke/iCal/compare/0.14.0...0.15.0
[0.14.0]: https://github.com/markuspoerschke/iCal/compare/0.13.0...0.14.0
[0.13.0]: https://github.com/markuspoerschke/iCal/compare/0.12.1...0.13.0
[0.12.1]: https://github.com/markuspoerschke/iCal/compare/0.12.0...0.12.1
[0.12.0]: https://github.com/markuspoerschke/iCal/compare/0.11.0...0.12.0
[0.11.5]: https://github.com/markuspoerschke/iCal/compare/0.11.4...0.11.5
[0.11.4]: https://github.com/markuspoerschke/iCal/compare/0.11.3...0.11.4
[0.11.3]: https://github.com/markuspoerschke/iCal/compare/0.11.2...0.11.3
[0.11.2]: https://github.com/markuspoerschke/iCal/compare/0.11.1...0.11.2
[0.11.1]: https://github.com/markuspoerschke/iCal/compare/0.11.0...0.11.1
[0.11.0]: https://github.com/markuspoerschke/iCal/compare/0.10.1...0.11.0
[0.10.0]: https://github.com/markuspoerschke/iCal/compare/0.9.0...0.10.0
[0.10.1]: https://github.com/markuspoerschke/iCal/compare/0.10.0...0.10.1
[0.9.0]: https://github.com/markuspoerschke/iCal/compare/0.8.0...0.9.0
