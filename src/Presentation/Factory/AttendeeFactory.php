<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2023 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\Entity\Attendee;
use Eluceo\iCal\Domain\Enum\CalendarUserType;
use Eluceo\iCal\Domain\Enum\ParticipationStatus;
use Eluceo\iCal\Domain\Enum\RoleType;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\BooleanValue;
use Eluceo\iCal\Presentation\Component\Property\Value\ListValue;
use Eluceo\iCal\Presentation\Component\Property\Value\QuotedUriValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Component\Property\Value\UriValue;
use UnexpectedValueException;

class AttendeeFactory
{
    public function createProperty(Attendee $attendee): Property
    {
        return new Property('ATTENDEE', new UriValue($attendee->getEmailAddress()->toUri()), $this->getParameters($attendee));
    }

    /**
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @return array<Property\Parameter>
     */
    private function getParameters(Attendee $attendee): array
    {
        $parameters = [];

        if ($attendee->hasCalendarUserType()) {
            $parameters[] = new Parameter('CUTYPE', $this->getCalendarUserTypeValue($attendee->getCalendarUserType()));
        }

        if ($attendee->hasMembers()) {
            $listAddressesEmail = [];
            foreach ($attendee->getMembers() as $member) {
                $listAddressesEmail[] = new QuotedUriValue($member->getEmailAddress()->toUri());
            }
            $parameters[] = new Parameter('MEMBER', new ListValue($listAddressesEmail));
        }

        if ($attendee->hasRole()) {
            $parameters[] = new Parameter('ROLE', $this->getRoleTypeValue($attendee->getRole()));
        }

        if ($attendee->hasParticipationStatus()) {
            $parameters[] = new Parameter('PARTSTAT', $this->getParticipantStatusTextValue($attendee->getParticipationStatus()));
        }

        if ($attendee->isRSVPenabled()) {
            $parameters[] = new Parameter('RSVP', new BooleanValue(true));
        }

        if ($attendee->hasDelegatedTo()) {
            $listAddressesEmail = [];
            foreach ($attendee->getDelegatedTo() as $delegatedToAddress) {
                $listAddressesEmail[] = new QuotedUriValue($delegatedToAddress->toUri());
            }
            $parameters[] = new Parameter('DELEGATED-TO', new ListValue($listAddressesEmail));
        }

        if ($attendee->hasDelegatedFrom()) {
            $listAddressesEmail = [];
            foreach ($attendee->getDelegatedFrom() as $delegatedFromAddress) {
                $listAddressesEmail[] = new QuotedUriValue($delegatedFromAddress->toUri());
            }
            $parameters[] = new Parameter('DELEGATED-FROM', new ListValue($listAddressesEmail));
        }

        if ($attendee->hasSentBy()) {
            $listAddressesEmail = [];
            foreach ($attendee->getSentBy() as $sentByAddress) {
                $listAddressesEmail[] = new QuotedUriValue($sentByAddress->toUri());
            }
            $parameters[] = new Parameter('SENT-BY', new ListValue($listAddressesEmail));
        }

        if ($attendee->hasDisplayName()) {
            $parameters[] = new Parameter('CN', new TextValue($attendee->getDisplayName()));
        }

        if ($attendee->hasDirectoryEntryReference()) {
            $parameters[] = new Parameter('DIR', new QuotedUriValue($attendee->getDirectoryEntryReference()));
        }

        if ($attendee->hasLanguage()) {
            $parameters[] = new Parameter('LANGUAGE', new TextValue($attendee->getLanguage()));
        }

        return $parameters;
    }

    private function getCalendarUserTypeValue(CalendarUserType $calendarUserType): TextValue
    {
        if ($calendarUserType === CalendarUserType::GROUP()) {
            return new TextValue('GROUP');
        }

        if ($calendarUserType === CalendarUserType::INDIVIDUAL()) {
            return new TextValue('INDIVIDUAL');
        }

        if ($calendarUserType === CalendarUserType::RESOURCE()) {
            return new TextValue('RESOURCE');
        }

        if ($calendarUserType === CalendarUserType::ROOM()) {
            return new TextValue('ROOM');
        }

        return new TextValue('UNKNOWN');
    }

    private function getRoleTypeValue(RoleType $roleType): TextValue
    {
        if ($roleType === RoleType::CHAIR()) {
            return new TextValue('CHAIR');
        }

        if ($roleType === RoleType::REQ_PARTICIPANT()) {
            return new TextValue('REQ-PARTICIPANT');
        }

        if ($roleType === RoleType::OPT_PARTICIPANT()) {
            return new TextValue('OPT-PARTICIPANT');
        }

        if ($roleType === RoleType::NON_PARTICIPANT()) {
            return new TextValue('NON-PARTICIPANT');
        }

        throw new UnexpectedValueException(sprintf('The enum %s resulted into an unknown role type value that is not yet implemented.', RoleType::class));
    }

    public function getParticipantStatusTextValue(ParticipationStatus $participationStatus): TextValue
    {
        if (ParticipationStatus::NEEDS_ACTION() === $participationStatus) {
            return new TextValue('NEEDS-ACTION');
        }

        if (ParticipationStatus::ACCEPTED() === $participationStatus) {
            return new TextValue('ACCEPTED');
        }

        if (ParticipationStatus::DECLINED() === $participationStatus) {
            return new TextValue('DECLINED');
        }

        if (ParticipationStatus::TENTATIVE() === $participationStatus) {
            return new TextValue('TENTATIVE');
        }

        if (ParticipationStatus::DELEGATED() === $participationStatus) {
            return new TextValue('DELEGATED');
        }

        if (ParticipationStatus::COMPLETED() === $participationStatus) {
            return new TextValue('COMPLETED');
        }

        if (ParticipationStatus::IN_PROCESS() === $participationStatus) {
            return new TextValue('IN-PROCESS');
        }

        throw new UnexpectedValueException(sprintf('The enum %s resulted into an unknown role type value that is not yet implemented.', ParticipationStatus::class));
    }
}
