# Change Log
All notable changes to this project will be documented in this file.

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

[Unreleased]: https://github.com/markuspoerschke/iCal/compare/0.11.0...HEAD
[0.11.0]: https://github.com/markuspoerschke/iCal/compare/0.10.1...0.11.0
[0.10.1]: https://github.com/markuspoerschke/iCal/compare/0.10.0...0.10.1
[0.10.0]: https://github.com/markuspoerschke/iCal/compare/0.9.0...0.10.0
[0.9.0]: https://github.com/markuspoerschke/iCal/compare/0.8.0...0.9.0
