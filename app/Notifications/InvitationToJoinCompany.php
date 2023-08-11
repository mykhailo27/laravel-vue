<?php

namespace App\Notifications;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitationToJoinCompany extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Company $company)
    {
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        /** @var User $notifiable */

        return (new MailMessage)
            ->subject('Company Membership Invitation')
            ->markdown('emails.invitation-to-join-company', [
                'company_name' => $this->company->name,
                'recipient_name' => $notifiable->name,
                'visit_company_route' => $this->getVisitCompanyRoute(),
                'password_reset_route' => $this->passwordResetRoute($notifiable)
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    private function passwordResetRoute(User $notifiable): ?string
    {
        if (is_null($notifiable->getAuthPassword())) {
            $token = app(PasswordBroker::class)->createToken($notifiable);

            return route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);
        }

        return null;
    }

    private function getVisitCompanyRoute(): string
    {
        return route('companies.details', [
            'company' => $this->company->id
        ]);
    }
}
