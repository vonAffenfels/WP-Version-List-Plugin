<?php

namespace VersionList;

class InformationCollector
{
    public static function getWordpressVersion(): ?string
    {
        global $wp_version;

        return $wp_version;
    }

    public static function getPluginVersions(): array
    {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $plugins = get_plugins();

        foreach ($plugins as $plugin)
        {
            $versions[$plugin['Name']] = $plugin['Version'];
        }
        return $versions;
    }

    public static function getName()
    {
        return get_bloginfo('name');
    }

    public static function getUrl()
    {
        return get_bloginfo('url');
    }

    public static function getPhpInfo()
    {
        $extensions = get_loaded_extensions();

        foreach ($extensions as $extension)
        {
            $extensionsWithVersion[$extension] = phpversion($extension);
        }

        return [
            'phpVersion' => phpversion(),
            'extensions' => $extensionsWithVersion ?? []
        ];
    }

    public static function getOtherInfo()
    {
        return apply_filters('vaf_version_list_add_information', []);
    }
}
