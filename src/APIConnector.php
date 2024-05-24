<?php

namespace VersionList;

class APIConnector
{
    /**
     * @throws \Exception
     */
    public function sendInformationToAPI(): void
    {
        $apiUrl = get_option('version_lists_settings_input_field_url');
        $token = get_option('version_lists_settings_input_field_token');
        $this->postToAPI(
            $apiUrl,
            $token,
            [
                "id" => get_option('version_lists_settings_input_field_id'),
                "url" => InformationCollector::getUrl(),
                "wordpressVersion" => InformationCollector::getWordpressVersion(),
                "plugins" => InformationCollector::getPluginVersions(),
                "phpInfo" => InformationCollector::getPhpInfo(),
                "other" => InformationCollector::getOtherInfo()
        ]);
    }

    private function postToAPI($apiUrl, $token, $data): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json',
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $responseData = json_decode($response, true);
        curl_close($ch);

        if (!($responseData['success'] ?? null))
        {
            throw new \Exception('Error sending API request: ' . $response);
        }

        $this->setNewToken($responseData['token']);
    }

    private function setNewToken($token)
    {
        update_option('version_lists_settings_input_field_token', $token);
    }
}
