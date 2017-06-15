<?php namespace GetRight\Contact;

use Backend;
use System\Classes\PluginBase;

/**
 * Contact Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Contact',
            'description' => 'Contact form',
            'author'      => 'GetRight',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers the mail templates.
     *
     * @return array
     */
    public function registerMailTemplates() {
        return [
            'getright.contact::emails.message' => 'Mail sent when contact form is submitted.'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'GetRight\Contact\Components\ContactForm' => 'ContactForm',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'getright.contact.settings_permissions' => [
                'tab' => 'Contact',
                'label' => 'Permissions for settings'
            ],
        ];
    }

    /**
     * Register backend settings menu.
     *
     * @return array
     */
    public function registerSettings() {
        return [
            'contact' => [
                'label'       => 'getRight Contact',
                'description' => 'Manage contact form settings',
                'category'    => 'Contact forms',
                'icon'        => 'icon-globe',
                'class'         => 'GetRight\Contact\Models\Settings',
                'permissions' => ['DevINX.ContactUs.access_settings'],
                'order'       => 100,
            ]
        ];
    }
}
