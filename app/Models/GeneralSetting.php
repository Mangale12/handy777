<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_setting';

    protected $fillable = [
        'captcha',
        'captcha_type',
        'api_key',
        'api_secret',
        'bonus_report_emails',
        'emails',
        'limit_amount',
        'spinner_message_monthly',
        'spinner_message',
        'above_limit_text',
        'between_limit_text',
        'below_limit_text',
        'theme',
        'site_name',
        'new_register_mail',
        'registration_email',
        'registration_sms',
        'mail_text',
        'spinner_date',
        'spinner_time',
        'sms_text',
        'spinner_winner_day',
        'spinner_time_cron',
        'inactive_mail_type',
        'inactive_mail_time',
        'inactive_mail_day',
        'inactive_mail_message',
        'emails_settings',
        'email_id_counter',
        'gameregames',
        'bulk_mail',
        'same_device',
        'page_link'
        
    ];
}
