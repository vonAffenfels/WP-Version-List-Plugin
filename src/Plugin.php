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
                'callback' => [$this, 'sendInformation'],
                'permission_callback' => '__return_true',
            ]);

            register_rest_route('version_list/v1', 'repository-url', [
                [
                    'methods' => 'GET',
                    'callback' => [$this, 'getRepositoryUrl'],
                    'permission_callback' => [$this, 'canManageRepositoryUrl'],
                ],
                [
                    'methods' => 'POST',
                    'callback' => [$this, 'setRepositoryUrl'],
                    'permission_callback' => [$this, 'canManageRepositoryUrl'],
                    'args' => [
                        'repositoryUrl' => [
                            'required' => true,
                            'type' => 'string',
                            'description' => 'GitHub or GitLab url of this instance. Pass an empty string to remove it.',
                            'validate_callback' => [$this, 'validateRepositoryUrl'],
                            'sanitize_callback' => 'esc_url_raw',
                        ],
                    ],
                ],
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


    public function getRepositoryUrl()
    {
        return [
            'success' => true,
            'repositoryUrl' => InformationCollector::getRepositoryUrl(),
        ];
    }


    public function setRepositoryUrl($request)
    {
        $repositoryUrl = $request->get_param('repositoryUrl');

        update_option(InformationCollector::OPTION_REPOSITORY_URL, $repositoryUrl);

        return [
            'success' => true,
            'repositoryUrl' => $repositoryUrl,
        ];
    }


    public function validateRepositoryUrl($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return $value === '' || filter_var($value, FILTER_VALIDATE_URL) !== false;
    }


    public function canManageRepositoryUrl(): bool
    {
        return current_user_can('manage_options');
    }


}
