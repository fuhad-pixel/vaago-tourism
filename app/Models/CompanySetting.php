<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'company_email', 'phone', 'whatsapp', 'address', 'working_days',
        'working_time', 'facebook', 'twitter', 'instagram', 'linkedin',
        'logo_path', 'favicon_path', 'og_image_path', 'privacy_policy', 'return_policy', 'gst', 'gst_number'
    ];
}
