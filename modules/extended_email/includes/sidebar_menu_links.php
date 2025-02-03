<?php

/*
 * Inject sidebar menu and links for customtables module
 */

if ($CI->db->table_exists(db_prefix().'extended_email_settings')) {
  hooks()->add_action('admin_init', function (){
          $staff = get_staff();
          $CI = &get_instance();
          $CI->app_menu->add_setup_menu_item('extended_email', [
              'slug'     => 'extended_email',
              'name'     => _l('extended_email'),
              'position' => 30,
          ]);

          $CI->app_menu->add_setup_children_item('extended_email', [
              'slug'     => 'extended_email_form',
              'name'     => _l('extended_email_form'),
              'href'     => admin_url('extended_email'),
              'position' => 2,
          ]);

          if (is_admin()) {
              $CI->app_menu->add_setup_children_item('extended_email', [
                  'slug'     => 'extended_email_log_history',
                  'name'     => _l('extended_email_log_history'),
                  'href'     => admin_url('extended_email/extended_email_log_history'),
                  'position' => 3,
              ]);
          }

  });
    $CI->config->load('extended_email/email', true);
    $settings = $CI->config->item('email');
    if ($settings['has_setting']) {
        $CI->load->library('email');
        $CI->email->initialize($CI->config->item('email'));
    }
}
