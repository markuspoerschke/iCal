<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2024 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Unit\Presentation\Factory;

use DateTimeImmutable;
use DateTimeZone;
use Eluceo\iCal\Domain\Entity\Attendee;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\Enum\CalendarUserType;
use Eluceo\iCal\Domain\Enum\EventStatus;
use Eluceo\iCal\Domain\Enum\ParticipationStatus;
use Eluceo\iCal\Domain\Enum\RoleType;
use Eluceo\iCal\Domain\ValueObject\Attachment;
use Eluceo\iCal\Domain\ValueObject\BinaryContent;
use Eluceo\iCal\Domain\ValueObject\Category;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;
use Eluceo\iCal\Domain\ValueObject\GeographicPosition;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\Member;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;
use Eluceo\iCal\Domain\ValueObject\Uri;
use Eluceo\iCal\Presentation\ContentLine;
use Eluceo\iCal\Presentation\Factory\EventFactory;
use PHPUnit\Framework\TestCase;

class EventFactoryTest extends TestCase
{
    public function testMinimalEvent()
    {
        $currentTime = new Timestamp(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-11-10 11:22:33',
                new DateTimeZone('UTC')
            )
        );

        $lastModified = new Timestamp(
            DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                '2019-10-09 10:11:22',
                new DateTimeZone('UTC')
            )
        );

        $event = (new Event(new UniqueIdentifier('event1')))
            ->touch($currentTime)
            ->setLastModified($lastModified)
        ;

        $expected = implode(ContentLine::LINE_SEPARATOR, [
            'BEGIN:VEVENT',
            'UID:event1',
            'DTSTAMP:20191110T112233Z',
            'LAST-MODIFIED:20191009T101122Z',
            'END:VEVENT',
            '',
        ]);

        self::assertSame($expected, (string) (new EventFactory())->createComponent($event));
    }

    public function testEventWithSummaryAndDescription()
    {
        $event = (new Event())
            ->setSummary('Lorem Summary')
            ->setDescription('Lorem Description');

        self::assertEventRendersCorrect($event, [
            'SUMMARY:Lorem Summary',
            'DESCRIPTION:Lorem Description',
        ]);
    }

    public function testEventWithLocation()
    {
        $geographicalPosition = new GeographicPosition(51.333333333333, 7.05);
        $location = (new Location('Location Name', 'Somewhere'))->withGeographicPosition($geographicalPosition);
        $event = (new Event())->setLocation($location);

        self::assertEventRendersCorrect(
            $event,
            [
                'LOCATION:Location Name',
                'GEO:51.333333;7.050000',
                'X-APPLE-STRUCTURED-LOCATION;VALUE=URI;X-ADDRESS=Location Name;X-APPLE-RADIU',
                ' S=49;X-TITLE=Somewhere:geo:51.333333,7.050000',
            ]
        );
    }

    public function testSingleDayEvent()
    {
        $event = (new Event())->setOccurrence(new SingleDay(new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'))));

        self::assertEventRendersCorrect($event, [
            'DTSTART;VALUE=DATE:20301224',
        ]);
    }

    public function testMultiDayEvent()
    {
        $firstDay = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-24'));
        $lastDay = new Date(DateTimeImmutable::createFromFormat('Y-m-d', '2030-12-26'));
        $occurrence = new MultiDay($firstDay, $lastDay);
        $event = (new Event())->setOccurrence($occurrence);

        self::assertEventRendersCorrect($event, [
            'DTSTART;VALUE=DATE:20301224',
            'DTEND;VALUE=DATE:20301227',
        ]);
    }

    public function testTimespanEvent()
    {
        $begin = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 12:15'), false);
        $end = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i', '2030-12-24 13:45'), false);
        $occurrence = new TimeSpan($begin, $end);
        $event = (new Event())->setOccurrence($occurrence);

        self::assertEventRendersCorrect($event, [
            'DTSTART:20301224T121500',
            'DTEND:20301224T134500',
        ]);
    }

    public function testUrlAttachments()
    {
        $event = (new Event())
            ->addAttachment(
                new Attachment(
                    new Uri('http://example.com/document.txt'),
                    'text/plain')
            );

        self::assertEventRendersCorrect($event, [
            'ATTACH;FMTTYPE=text/plain:http://example.com/document.txt',
        ]);
    }

    public function testFileAttachments()
    {
        $event = (new Event())
            ->addAttachment(
                new Attachment(
                    new BinaryContent('Hello World!'),
                    'text/plain'
                )
            );

        self::assertEventRendersCorrect($event, [
            'ATTACH;FMTTYPE=text/plain;ENCODING=BASE64;VALUE=BINARY:SGVsbG8gV29ybGQh',
        ]);
    }

    public function testOrganizer()
    {
        $event = (new Event())
            ->setOrganizer(new Organizer(
                new EmailAddress('test@example.com'),
                'Test Display Name',
                new Uri('example://directory-entry'),
                new EmailAddress('sendby@example.com')
            ));

        self::assertEventRendersCorrect($event, [
            'ORGANIZER;CN=Test Display Name;DIR=example://directory-entry;SENT-BY=mailto',
            ' :sendby@example.com:mailto:test@example.com',
        ]);
    }

    public function testOneAttendee()
    {
        $event = (new Event())
            ->addAttendee(new Attendee(
                new EmailAddress('test@example.com')
            ));

        self::assertEventRendersCorrect($event, [
            'ATTENDEE:mailto:test@example.com',
        ]);
    }

    public function testMultipleAttendees()
    {
        $event = (new Event())
            ->addAttendee(new Attendee(
                new EmailAddress('test@example.com')
            ))
            ->addAttendee(new Attendee(
                new EmailAddress('test2@example.net')
            ));

        self::assertEventRendersCorrect($event, [
            'ATTENDEE:mailto:test@example.com',
            'ATTENDEE:mailto:test2@example.net',
        ]);
    }

    /*  public function testAttendeeWithCN()
     {
         $event = (new Event())
             ->addAttendee(new Attendee(
                 new EmailAddress('test@example.com'),
                 null,
                 'Test Display Name',
             ));

         self::assertEventRendersCorrect($event, [
             'ATTENDEE;CN=Test Display Name:mailto:test@example.com',
         ]);
     } */

    public function testAttendeeWithIndividualCUtype()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::INDIVIDUAL());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=INDIVIDUAL:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithGroupCUtype()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::GROUP());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=GROUP:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithResourceCUtype()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::RESOURCE());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=RESOURCE:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithRoomCUtype()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::ROOM());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=ROOM:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithUnknownCUtype()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::UNKNOWN());

        $event = (new Event())
            ->addAttendee($attendee);
        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=UNKNOWN:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithOneMember()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::INDIVIDUAL());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=INDIVIDUAL:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithMultipleMembers()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setCalendarUserType(CalendarUserType::INDIVIDUAL())
            ->addMember(new Member(new EmailAddress('test@example.com')))
            ->addMember(new Member(new EmailAddress('test@example.net')));

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CUTYPE=INDIVIDUAL;MEMBER="mailto:test@example.com","mailto:test@ex',
            ' ample.net":mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithChairRole()
    {
        $attendee = new Attendee(new EmailAddress('test@example.com'));
        $attendee->setRole(RoleType::CHAIR());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;ROLE=CHAIR:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithReqParticipantRole()
    {
        $attendee = new Attendee(
            new EmailAddress('test@example.com'),
        );
        $attendee->setRole(RoleType::REQ_PARTICIPANT());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;ROLE=REQ-PARTICIPANT:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithParticipationStatusNeedsAction()
    {
        $attendee = new Attendee(
            new EmailAddress('test@example.com'),
        );

        $attendee->setParticipationStatus(ParticipationStatus::NEEDS_ACTION());

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;PARTSTAT=NEEDS-ACTION:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithRSVP()
    {
        $attendee = new Attendee(
            new EmailAddress('test@example.com'),
        );

        $attendee->setResponseNeededFromAttendee(true);

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;RSVP=TRUE:mailto:test@example.com',
        ]);
    }

    public function testAttendeeWithDelegatedTo()
    {
        $attendee = new Attendee(
            new EmailAddress('jsmith@example.com'),
        );

        $attendee->addDelegatedTo(
            new EmailAddress('jdoe@example.com')
        )->addDelegatedTo(
            new EmailAddress('jqpublic@example.com')
        );

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;DELEGATED-TO="mailto:jdoe@example.com","mailto:jqpublic@example.co',
            ' m":mailto:jsmith@example.com',
        ]);
    }

    public function testAttendeeWithDelegatedFrom()
    {
        $attendee = new Attendee(
            new EmailAddress('jdoe@example.com'),
        );

        $attendee->addDelegatedFrom(
            new EmailAddress('jsmith@example.com')
        );

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;DELEGATED-FROM="mailto:jsmith@example.com":mailto:jdoe@example.com',
        ]);
    }

    public function testAttendeeWithSentBy()
    {
        $attendee = new Attendee(
            new EmailAddress('jdoe@example.com'),
        );

        $attendee->addSentBy(
            new EmailAddress('sray@example.com')
        );

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;SENT-BY="mailto:sray@example.com":mailto:jdoe@example.com',
        ]);
    }

    public function testAttendeeWithCommonName()
    {
        $attendee = new Attendee(
            new EmailAddress('jdoe@example.com'),
        );

        $attendee->setDisplayName('Test Example');

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;CN=Test Example:mailto:jdoe@example.com',
        ]);
    }

    public function testAttendeeWithDirectoryEntryRef()
    {
        $attendee = new Attendee(
            new EmailAddress('jdoe@example.com'),
        );

        $attendee->setDirectoryEntryReference(new Uri('ldap://example.com:6666/o=ABC%20Industries,c=US???(cn=Jim%20Dolittle)'));

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;DIR="ldap://example.com:6666/o=ABC%20Industries,c=US???(cn=Jim%20D',
            ' olittle)":mailto:jdoe@example.com',
        ]);
    }

    public function testAttendeeWithLanguage()
    {
        $attendee = new Attendee(
            new EmailAddress('jdoe@example.com'),
        );

        $attendee->setLanguage('en-US');

        $event = (new Event())
            ->addAttendee($attendee);

        self::assertEventRendersCorrect($event, [
            'ATTENDEE;LANGUAGE=en-US:mailto:jdoe@example.com',
        ]);
    }

    public function testEventUrl()
    {
        $event = (new Event())
            ->setUrl(new Uri('https://example.org/calendarevent'));

        self::assertEventRendersCorrect($event, [
            'URL:https://example.org/calendarevent',
        ]);
    }

    public function testEventWithOneCategory()
    {
        $category = new Category('category');
        $event = (new Event())->addCategory($category);

        self::assertEventRendersCorrect(
            $event,
            [
                'CATEGORIES:category',
            ]
        );
    }

    public function testEventWithMultipleCategories()
    {
        $event = (new Event())
            ->addCategory(new Category('category 1'))
            ->addCategory(new Category('category 2'));

        self::assertEventRendersCorrect(
            $event,
            [
                'CATEGORIES:category 1,category 2',
            ]
        );
    }

    public function testEventWithCancelledStatus(): void
    {
        $event = (new Event())->setStatus(EventStatus::CANCELLED());

        self::assertEventRendersCorrect($event, [
            'STATUS:CANCELLED',
        ]);
    }

    public function testEventWithConfirmedStatus(): void
    {
        $event = (new Event())->setStatus(EventStatus::CONFIRMED());

        self::assertEventRendersCorrect($event, [
            'STATUS:CONFIRMED',
        ]);
    }

    public function testEventWithTentativeStatus(): void
    {
        $event = (new Event())->setStatus(EventStatus::TENTATIVE());

        self::assertEventRendersCorrect($event, [
            'STATUS:TENTATIVE',
        ]);
    }

    private static function assertEventRendersCorrect(Event $event, array $expected)
    {
        $resultAsString = (string) (new EventFactory())->createComponent($event);

        $resultAsArray = explode(ContentLine::LINE_SEPARATOR, $resultAsString);

        self::assertGreaterThan(5, count($resultAsArray), 'No additional content lines were produced.');

        $resultAsArray = array_slice($resultAsArray, 3, -2);
        self::assertSame($expected, $resultAsArray);
    }
}
