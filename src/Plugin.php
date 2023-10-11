<?php

namespace VersionList;

class Plugin
{
    public function init()
    {
        $settingsPage = new SettingsPage();
        $settingsPage->initSettingsPage();

        if (isset($_POST['btn-send-to-api']))
        {
            $apiConnector = new APIConnector();
            $apiConnector->sendInformationToAPI();
        }

        if (!wp_next_scheduled('version_list_daily_cron'))
        {
            $this->initCronJob();
        }
    }


    private function initCronJob()
    {
        wp_schedule_event(time(), 'daily', 'version_list_daily_cron');

        add_action('version_list_daily_cron', function (){
            $apiConnector = new APIConnector();
            $apiConnector->sendInformationToAPI();
        });
    }
}
