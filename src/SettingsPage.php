<?php

namespace VersionList;

class SettingsPage
{
    public function initSettingsPage()
    {
        add_action('admin_menu', [$this,'version_lists_settings_menu']);
        add_action('admin_init', [$this,'version_lists_settings_init'] );
    }

    public function version_lists_settings_menu() {

        add_menu_page(
            __( 'Version List Settings', 'version-list' ),
            __( 'Version List Settings', 'version-list' ),
            'manage_options',
            'version-list-settings-page',
            [$this,'version_lists_settings_template_callback'],
            '',
            null
        );

    }

    public function version_lists_settings_template_callback() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

            <form action="options.php" method="post">
                <?php
                // security field
                settings_fields( 'version-list-settings-page' );

                // output settings section here
                do_settings_sections('version-list-settings-page');

                // save settings button
                submit_button( 'Save Settings' );
                ?>
            </form>
            <form method="post">
                <input type="submit" name="btn-send-to-api" value="Send Information to API">
            </form>
        </div>
        <?php
    }

    /**
     * Settings Template
     */
    public function version_lists_settings_init() {

        // Setup settings section
        add_settings_section(
            'version_lists_settings_section',
            'version-list Settings Page',
            '',
            'version-list-settings-page'
        );

        // Register ID input field
        register_setting(
            'version-list-settings-page',
            'version_lists_settings_input_field_id',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        // Add ID fields
        add_settings_field(
            'version_lists_settings_input_field_id',
            __( 'ID', 'version-list' ),
            [$this,'version_lists_settings_input_field_id_callback'],
            'version-list-settings-page',
            'version_lists_settings_section'
        );

        // Registe token input field
        register_setting(
            'version-list-settings-page',
            'version_lists_settings_input_field_token',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        // Register token input field
        register_setting(
            'version-list-settings-page',
            'version_lists_settings_input_field_token',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        // Add token fields
        add_settings_field(
            'version_lists_settings_input_field_token',
            __( 'Token', 'version-list' ),
            [$this,'version_lists_settings_input_field_token_callback'],
            'version-list-settings-page',
            'version_lists_settings_section'
        );

        // Register url input field
        register_setting(
            'version-list-settings-page',
            'version_lists_settings_input_field_url',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        // Add url fields
        add_settings_field(
            'version_lists_settings_input_field_url',
            __( 'Api Url', 'version-list' ),
            [$this,'version_lists_settings_input_field_url_callback'],
            'version-list-settings-page',
            'version_lists_settings_section'
        );
    }


    public function version_lists_settings_input_field_token_callback() {
        $version_listinput_field = get_option('version_lists_settings_input_field_token');
        ?>
        <input type="text" name="version_lists_settings_input_field_token" class="regular-text" value="<?php echo isset($version_listinput_field) ? esc_attr( $version_listinput_field ) : ''; ?>" />
        <?php
    }


    public function version_lists_settings_input_field_url_callback() {
        $version_listinput_field = get_option('version_lists_settings_input_field_url');
        ?>
        <input type="text" name="version_lists_settings_input_field_url" class="regular-text" value="<?php echo isset($version_listinput_field) ? esc_attr( $version_listinput_field ) : ''; ?>" />
        <?php
    }


    public function version_lists_settings_input_field_id_callback() {
        $version_listinput_field = get_option('version_lists_settings_input_field_id');
        ?>
        <input type="text" name="version_lists_settings_input_field_id" class="regular-text" value="<?php echo isset($version_listinput_field) ? esc_attr( $version_listinput_field ) : ''; ?>" />
        <?php
    }
}
