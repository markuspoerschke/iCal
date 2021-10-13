<?php

/*
 * This file is part of the eluceo/iCal package.
 *
 * (c) 2021 Markus Poerschke <markus@poerschke.nrw>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Eluceo\iCal\Presentation\Factory;

use Eluceo\iCal\Domain\ValueObject\Attendee;
use Eluceo\iCal\Presentation\Component\Property;
use Eluceo\iCal\Presentation\Component\Property\Parameter;
use Eluceo\iCal\Presentation\Component\Property\Value\BooleanValue;
use Eluceo\iCal\Presentation\Component\Property\Value\ListValue;
use Eluceo\iCal\Presentation\Component\Property\Value\QuotedUriValue;
use Eluceo\iCal\Presentation\Component\Property\Value\TextValue;
use Eluceo\iCal\Presentation\Component\Property\Value\UriValue;

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
            $parameters[] = new Parameter('CUTYPE', new TextValue($attendee->getCalendarUserType()));
        }

        if ($attendee->hasMembers()) {
            $listAddressesEmail = [];
            foreach ($attendee->getMembers() as $member) {
                $listAddressesEmail[] = new QuotedUriValue($member->getEmailAddress()->toUri());
            }
            $parameters[] = new Parameter('MEMBER', new ListValue($listAddressesEmail));
        }

        if ($attendee->hasRole()) {
            $parameters[] = new Parameter('ROLE', new TextValue($attendee->getRole()));
        }

        if ($attendee->hasParticipationStatus()) {
            $parameters[] = new Parameter('PARTSTAT', new TextValue($attendee->getParticipationStatus()));
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
}
