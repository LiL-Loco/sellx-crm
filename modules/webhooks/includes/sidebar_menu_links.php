<?php

// Inject sidebar menu and links for webhooks module
hooks()->add_action('admin_init', function (){
    $CI = &get_instance();
    if (has_permission('webhooks', '', 'view')) {
        $CI->app_menu->add_setup_menu_item('webhooks', [
            'slug'     => 'webhooks',
            'name'     => _l('webhooks'),
            'href'     => 'webhooks',
            'position' => 30,
        ]);
    }

    if (has_permission('webhooks', '', 'view')) {
        $CI->app_menu->add_setup_children_item('webhooks', [
            'slug'     => 'webhooks',
            'name'     => _l('webhooks'),
            'href'     => admin_url(WEBHOOKS_MODULE . '/webhooks'),
            'position' => 1,
        ]);
    }

    if (has_permission('webhooks', '', 'view')) {
        $CI->app_menu->add_setup_children_item('webhooks', [
            'slug'     => 'webhook_log',
            'name'     => _l('webhook_log'),
            'href'     => admin_url(WEBHOOKS_MODULE . '/logs'),
            'position' => 5,
        ]);
    }
});