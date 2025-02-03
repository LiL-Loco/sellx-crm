<?php


hooks()->add_action('before_perform_update', 'deactivate_extended_email_module');
function deactivate_extended_email_module($latest_version)
{
    $CI = &get_instance();
    $CI->app_modules->deactivate('extended_email');
}