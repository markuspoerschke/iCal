# Change Log
All notable changes to this project will be documented in this file.

## [Unreleased]
### Changed
- Use 'escapeValue' to escape the new line character. [#60](https://github.com/markuspoerschke/iCal/pull/60)

### Added
- X-ALT-DESC for HTML types with new descriptionHTML field. [#55](https://github.com/markuspoerschke/iCal/pull/55)


## [0.9.0] - 2015-11-13
### Added
- CHANGELOG.md based on [’Keep a CHANGELOG’](https://github.com/olivierlacan/keep-a-changelog)
- Support event properties EXDATE and RECURRENCE-ID [#50](https://github.com/markuspoerschke/iCal/pull/53)

### Changed
- Allow new lines in event descriptions [#53](https://github.com/markuspoerschke/iCal/pull/53)
- **Breaking Change:** Changed signature of the ```Event::setOrganizer``` method. Now there is is only one parameter that must be an instance of ```Property\Organizer```.
- Updated install section in README.md [#54](https://github.com/markuspoerschke/iCal/pull/53)

[Unreleased]: https://github.com/markuspoerschke/iCal/compare/0.9.0...HEAD
[0.9.0]: https://github.com/markuspoerschke/iCal/compare/0.8.0...0.8.0
