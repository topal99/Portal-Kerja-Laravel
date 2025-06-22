<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\JobApplication;

class ApplicantStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jobTitle = $this->application->jobListing->title;
        $companyName = $this->application->jobListing->companyProfile->company_name;
        $status = $this->application->status;

        $subject = "Update Status Lamaran Anda untuk Posisi {$jobTitle}";
        $line = "Ada pembaruan status untuk lamaran Anda pada posisi **{$jobTitle}** di **{$companyName}**.";
        
        if ($status == 'accepted') {
            $line2 = "Selamat! Lamaran Anda telah **DITERIMA**. Pihak perusahaan akan segera menghubungi Anda untuk tahap selanjutnya.";
        } elseif ($status == 'rejected') {
            $line2 = "Mohon maaf, lamaran Anda untuk saat ini **DITOLAK**. Jangan menyerah dan tetap semangat mencari peluang lainnya di platform kami!";
        } else {
             $line2 = "Status lamaran Anda saat ini adalah: **".ucfirst($status)."**.";
        }

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line($line)
                    ->line($line2)
                    ->action('Lihat Riwayat Lamaran', route('seeker.applications'))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }
}