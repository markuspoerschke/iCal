# Change Log
All notable changes to this project will be documented in this file.

## [0.11.3] - 2017-04-25
### Fixed
- Fix the GEO property (compatibility to PHP < 7) [#91](https://github.com/markuspoerschke/iCal/pull/91) [#91](https://github.com/markuspoerschke/iCal/pull/93)

## [0.11.2] - 2017-04-21
### Fixed
- Do not escape value of the GEO property [#79](https://github.com/markuspoerschke/iCal/pull/79)

## [0.11.1] - 2017-04-04
### Fixed
- All days events (no time) ends on the next day. [#83](https://github.com/markuspoerschke/iCal/pull/83)
- Timezone will not applied on all days events [#83](https://github.com/markuspoerschke/iCal/pull/83)

### Added
- Add `Event::getDtStart` method [#83](https://github.com/markuspoerschke/iCal/pull/83)

## [0.11.0] - 2016-09-16
### Added
- Allow multiple recurrence rules in an event [#77](https://github.com/markuspoerschke/iCal/pull/77)
- RecurrenceRule now also allows hourly, minutely and secondly frequencies [#78](https://github.com/markuspoerschke/iCal/pull/78)

### Deprecated
- Adding a single recurrence rule to an event using `Event::setRecurrenceRule()` is deprecated and will be removed in 1.0. Use `Event::addRecurrenceRule()` instead. [#77](https://github.com/markuspoerschke/iCal/pull/77)

## [0.10.1] - 2016-05-09
### Fixed
- Problem with GEO property when importing into Google Calendar [#74](https://github.com/markuspoerschke/iCal/pull/74)

## [0.10.0] - 2016-04-26
### Changed
- Use 'escapeValue' to escape the new line character. [#60](https://github.com/markuspoerschke/iCal/pull/60)
- Order components by type when building ical file. [#65](https://github.com/markuspoerschke/iCal/pull/65)

### Added
- X-ALT-DESC for HTML types with new descriptionHTML field. [#55](https://github.com/markuspoerschke/iCal/pull/55)
- Added a property and setter for calendar color. [#68](https://github.com/markuspoerschke/iCal/pull/68)
- Write also GEO property if geo location is given. [#66](https://github.com/markuspoerschke/iCal/pull/66)

## [0.9.0] - 2015-11-13
### Added
- CHANGELOG.md based on [’Keep a CHANGELOG’](https://github.com/olivierlacan/keep-a-changelog)
- Support event properties EXDATE and RECURRENCE-ID [#50](https://github.com/markuspoerschke/iCal/pull/53)

### Changed
- Allow new lines in event descriptions [#53](https://github.com/markuspoerschke/iCal/pull/53)
- **Breaking Change:** Changed signature of the ```Event::setOrganizer``` method. Now there is is only one parameter that must be an instance of ```Property\Organizer```.
- Updated install section in README.md [#54](https://github.com/markuspoerschke/iCal/pull/53)

[0.11.3]: https://github.com/markuspoerschke/iCal/compare/0.11.2...0.11.3
[0.11.2]: https://github.com/markuspoerschke/iCal/compare/0.11.1...0.11.2
[0.11.1]: https://github.com/markuspoerschke/iCal/compare/0.11.0...0.11.1
[0.11.0]: https://github.com/markuspoerschke/iCal/compare/0.10.1...0.11.0
[0.10.1]: https://github.com/markuspoerschke/iCal/compare/0.10.0...0.10.1
[0.10.0]: https://github.com/markuspoerschke/iCal/compare/0.9.0...0.10.0
[0.9.0]: https://github.com/markuspoerschke/iCal/compare/0.8.0...0.9.0
