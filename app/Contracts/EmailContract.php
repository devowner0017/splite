<?php


namespace App\Contracts;


interface EmailContract {

    public function __construct();

    public function sendRegisterEmail(array $to, string $firstName): bool;

    public function sendForgotPasswordCode(array $to, string $firstName, string $code): bool;

    public function sendVerificationCode(array $to, string $firstName, string $code): bool;

    public function sendEventInvitation(array $to, string $firstName, string $link): bool;

    public function sendCreateEventEmail(
        array $to,
        string $plannerFirstName, 
        string $plannerEmail, 
        string $description, 
        string $venueName, 
        string $startDate, 
        string $startTime
    ): bool;

    public function sendInvitationAcceptedEmail(
        array $to,
        string $plannerFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool;

    public function sendInvitationDeclinedEmail(
        array $to,
        string $plannerFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool;

    public function sendPaymentCompletedEmailContact(array $to, string $firstName, string $serviceName): bool;

    public function sendPaymentCompletedEmailMerchant(
        array $to,
        string $merchantFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool;

    public function sendPaymentCompletedEmailPlanner(
        array $to,
        string $plannerFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool;
}
