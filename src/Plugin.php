<?php

namespace VersionList;

class Plugin
{
    public function init(): void
    {
        $settingsPage = new SettingsPage();
        $settingsPage->initSettingsPage();
        $apiConnector = new APIConnector();

        if (isset($_POST['btn-send-to-api']))
        {
            try {
                $apiConnector->sendInformationToAPI();
            } catch (\Exception $e) {
                echo "<pre>", var_dump($e), "</pre>";
                die();
            }
        }

        $this->addHooks();

    }


    private function addHooks(): void
    {
        add_action('rest_api_init', function (){
            register_rest_route('version_list/v1', 'send', [
                'methods' => 'GET',
                'callback' => [$this, 'sendInformation']
            ]);
        });
    }


    public function sendInformation()
    {
        $apiConnector = new APIConnector();

        try {
            $apiConnector->sendInformationToAPI();
        } catch (\Exception $e) {
            return $e;
        }

        return 'success';
    }


}
