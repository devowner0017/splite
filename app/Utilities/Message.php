<?php


namespace App\Utilities;


class Message {

    private function __construct() {}

    const SOMETHING_WENT_WRONG = 'Something went wrong, please try again';
    const UNAUTHORIZED = 'Unauthorized';
    const WRONG_CREDENTIALS = 'These credentials do not match our records';
    const CODE_MISMATCH = 'Verification code mismatch';
    const RESET_CODE_MISMATCH = 'Reset code mismatch';
    const NOT_FOUND = 'Resource not found';
    const NOT_VERIFIED = 'Resource not verified';
    const USER_IS_NOT_MERCHANT = 'User is not merchant';
    const USER_IS_NOT_PLANNER = 'User is not planner';
    const PRIMARY_PAYMENT_METHOD = 'Cannot remove the primary payment method';
    const CONTACT_INVITED = 'One or more contacts have been already invited to this event';
    const CONTACT_NOT_FOUND = 'One or more contacts not found';
    const EVENT_ALREADY_APPROVED = 'Event is already approved';
    const EVENT_ALREADY_DENIED = 'Event is already denied';
    const EVENT_ALREADY_CANCELLED = 'Event is already cancelled';
    const EVENT_STATUS_IS_ALREADY_SET = 'Event status is already set';
    const INVITATION_STATUS_IS_ALREADY_SET = 'Invitation status is already set';
    const CONTACT_EXISTS = 'Contact with the same email already exists';
}
