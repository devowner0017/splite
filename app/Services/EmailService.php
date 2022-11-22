<?php


namespace App\Services;

use App\Contracts\EmailContract;
use Illuminate\Support\Facades\Log;
use MailchimpTransactional\ApiClient;

class EmailService implements EmailContract {

    protected array $framework;

    protected ApiClient $client;

    public function __construct() {
        $this->client = new ApiClient();
        $this->client->setApiKey(config('mandrill.key'));
        $this->framework = [
            'template_name' => null,
            'template_content' => [
                [
                    "name" => "header",
                    "content" => "",
                ],
            ],
            'message' => [
                'to' => [],
                'global_merge_vars' => [],
            ],
        ];
    }

    public function sendRegisterEmail(array $to, string $firstName): bool {
        return $this->send(config('mandrill.register'), $to, [
            [
                'name' => 'first_name',
                'content' => $firstName,
            ],
        ]);
    }

    public function sendForgotPasswordCode(array $to, string $firstName, string $code): bool {
        return $this->send(config('mandrill.forgot'), $to, [
            [
                'name' => 'first_name',
                'content' => $firstName,
            ],
            [
                'name' => 'code',
                'content' => $code,
            ]
        ]);
    }

    public function sendVerificationCode(array $to, string $firstName, string $code): bool {
        return $this->send(config('mandrill.verification'), $to, [
            [
                'name' => 'first_name',
                'content' => $firstName,
            ],
            [
                'name' => 'code',
                'content' => $code,
            ]
        ]);
    }

    public function sendEventInvitation(array $to, string $firstName, string $link): bool {
        return $this->send(config('mandrill.event_invitation'), $to, [
            [
                'name' => 'first_name',
                'content' => $firstName,
            ],
            [
                'name' => 'link',
                'content' => $link,
            ]
        ]);
    }

    public function sendCreateEventEmail(array $to, string $plannerFirstName, string $plannerEmail, string $description, string $venueName, string $startDate, string $startTime): bool {
        return $this->send(config('mandrill.create_event'), $to, [
            [
                'name' => 'planner_name',
                'content' => $plannerFirstName
            ],
            [
                'name' => 'planner_email',
                'content' => $plannerEmail
            ],
            [
                'name' => 'description',
                'content' => $description
            ],
            [
                'name' => 'venue_name',
                'content' => $venueName
            ],
            [
                'name' => 'start_date',
                'content' => $startDate
            ],
            [
                'name' => 'start_time',
                'content' => $startTime
            ]
        ]);
    }

    public function sendInvitationAcceptedEmail(
        array $to,
        string $plannerFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool {
        return $this->send(config('mandrill.invitation_accepted'), $to, [
            [
                'name' => 'first_name',
                'content' => $plannerFirstName,
            ],
            [
                'name' => 'contact_first_name',
                'content' => $contactFirstName,
            ],
            [
                'name' => 'contact_email',
                'content' => $contactEmail,
            ],
            [
                'name' => 'service_name',
                'content' => $serviceName,
            ],
        ]);
    }

    public function sendInvitationDeclinedEmail(
        array $to,
        string $plannerFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool {
        return $this->send(config('mandrill.invitation_declined'), $to, [
            [
                'name' => 'first_name',
                'content' => $plannerFirstName,
            ],
            [
                'name' => 'contact_first_name',
                'content' => $contactFirstName,
            ],
            [
                'name' => 'contact_email',
                'content' => $contactEmail,
            ],
            [
                'name' => 'service_name',
                'content' => $serviceName,
            ],
        ]);
    }

    public function sendPaymentCompletedEmailContact(array $to, string $firstName, string $serviceName): bool {
        return $this->send(config('mandrill.payment_completed_contact'), $to, [
            [
                'name' => 'first_name',
                'content' => $firstName,
            ],
            [
                'name' => 'service_name',
                'content' => $serviceName,
            ],
        ]);
    }

    public function sendPaymentCompletedEmailMerchant(
        array $to,
        string $merchantFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool {
        return $this->send(config('mandrill.payment_completed_merchant'), $to, [
            [
                'name' => 'first_name',
                'content' => $merchantFirstName,
            ],
            [
                'name' => 'contact_first_name',
                'content' => $contactFirstName,
            ],
            [
                'name' => 'contact_email',
                'content' => $contactEmail,
            ],
            [
                'name' => 'service_name',
                'content' => $serviceName,
            ],
        ]);
    }

    public function sendPaymentCompletedEmailPlanner(
        array $to,
        string $plannerFirstName,
        string $contactFirstName,
        string $contactEmail,
        string $serviceName
    ): bool {
        return $this->send(config('mandrill.payment_completed_planner'), $to, [
            [
                'name' => 'first_name',
                'content' => $plannerFirstName,
            ],
            [
                'name' => 'contact_first_name',
                'content' => $contactFirstName,
            ],
            [
                'name' => 'contact_email',
                'content' => $contactEmail,
            ],
            [
                'name' => 'service_name',
                'content' => $serviceName,
            ],
        ]);
    }

    protected function send(string $template, array $to, array $vars): bool {
        $this->framework['template_name'] = $template;
        $this->framework['message']['to'][] = $to;
        $this->framework['message']['global_merge_vars'] = $vars;

        print_r($this->framework);

        $response = $this->client->messages->sendTemplate($this->framework);

        if (is_string($response)) {
            Log::debug('Failed to send an email', [
                'framework' => $this->framework,
                'response' => $response,
            ]);
            return false;
        }

        return true;
    }
}
