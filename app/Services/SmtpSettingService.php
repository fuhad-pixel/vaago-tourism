<?php

namespace App\Services;

use App\Models\SmtpSetting;

class SmtpSettingService
{
    /**
     * Update the SMTP settings.
     *
     * @param array $data
     * @return SmtpSetting
     */
    public function updateSettings(array $data)
    {
        $setting = SmtpSetting::first() ?? new SmtpSetting();
        $setting->fill($data);
        $setting->save();

        return $setting;
    }
}
