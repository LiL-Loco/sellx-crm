<?php defined('BASEPATH') or exit('No direct script access allowed');
// Means module is disabled

?>
<!DOCTYPE html>
<html lang="<?= e($locale); ?>">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?= $title ?? ''; ?></title>
	<?= compile_theme_css(); ?>

	<?php app_customers_head(); ?>
</head>


<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<nav class="navbar navbar-default header">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#theme-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php get_dark_company_logo('', 'navbar-brand logo'); ?>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="theme-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php hooks()->do_action('customers_navigation_start'); ?>
                <?php foreach ($menu as $item_id => $item) { ?>
                <li class="customers-nav-item-<?= e($item_id); ?><?= $item['href'] === current_full_url() ? ' active' : ''; ?>"
                    <?= _attributes_to_string($item['li_attributes'] ?? []); ?>>
                    <a href="<?= e($item['href']); ?>"
                        <?= _attributes_to_string($item['href_attributes'] ?? []); ?>>
                        <?php
                     if (! empty($item['icon'])) {
                         echo '<i class="' . $item['icon'] . '"></i> ';
                     }
                    echo e($item['name']);
                    ?>
                    </a>
                </li>
                <?php } ?>
                <?php hooks()->do_action('customers_navigation_end'); ?>
                <?php if (is_client_logged_in()) { ?>
                <li class="dropdown customers-nav-item-profile">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="<?= e(contact_profile_image_url($contact->id, 'thumb')); ?>
" data-toggle="tooltip" data-title="<?= e($contact->firstname . ' ' . $contact->lastname); ?>"
                            data-placement="bottom" class="client-profile-image-small">
                    </a>
                    <ul class="dropdown-menu animated fadeIn">
                        <li class="customers-nav-item-edit-profile">
                            <a
                                href="<?= site_url('clients/profile'); ?>">
                                <?= _l('clients_nav_profile'); ?>
                            </a>
                        </li>
                        <?php if ($contact->is_primary == 1) { ?>
                        <?php if (can_loggged_in_user_manage_contacts()) { ?>
                        <li class="customers-nav-item-edit-profile">
                            <a
                                href="<?= site_url('contacts'); ?>">
                                <?= _l('clients_nav_contacts'); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="customers-nav-item-company-info">
                            <a
                                href="<?= site_url('clients/company'); ?>">
                                <?= _l('client_company_info'); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if (can_logged_in_contact_update_credit_card()) { ?>
                        <li class="customers-nav-item-stripe-card">
                            <a
                                href="<?= site_url('clients/credit_card'); ?>">
                                <?= _l('credit_card'); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if (is_gdpr() && get_option('show_gdpr_in_customers_menu') == '1') { ?>
                        <li class="customers-nav-item-announcements">
                            <a
                                href="<?= site_url('clients/gdpr'); ?>">
                                <?= _l('gdpr_short'); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="customers-nav-item-announcements">
                            <a
                                href="<?= site_url('clients/announcements'); ?>">
                                <?= _l('announcements'); ?>
                                <?php if ($total_undismissed_announcements != 0) { ?>
                                <span
                                    class="badge"><?= e($total_undismissed_announcements); ?></span>
                                <?php } ?>
                            </a>
                        </li>
                        <?php if (! is_language_disabled()) {
                            ?>
                        <li class="dropdown-submenu pull-left customers-nav-item-languages">
                            <a href="#" tabindex="-1">
                                <?= _l('language'); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-left">
                                <li class="<?php if (get_contact_language() == '') {
                                    echo 'active';
                                } ?>">
                                    <a
                                        href="<?= site_url('clients/change_language'); ?>">
                                        <?= _l('system_default_string'); ?>
                                    </a>
                                </li>
                                <?php foreach ($this->app->get_available_languages() as $user_lang) { ?>
                                <li <?php if (get_contact_language() == $user_lang) {
                                    echo 'class="active"';
                                } ?>>
                                    <a
                                        href="<?= site_url('clients/change_language/' . $user_lang); ?>">
                                        <?= e(ucfirst($user_lang)); ?>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php
                        } ?>
                        <?= hooks()->do_action('customers_navigation_before_logout'); ?>
                        <li class="customers-nav-item-logout">
                            <a
                                href="<?= site_url('authentication/logout'); ?>">
                                <?= _l('clients_nav_logout'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
                <?php hooks()->do_action('customers_navigation_after_profile'); ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div id="wrapper">
    <div id="content">
        <div class="container">
        <div class="row">
                    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                        <div class="panel_s">
                            <div class="panel-body">
                                <div class="form-group">
            <div id="response"></div>

            <?php echo form_open('appointly/appointments_public/create_external_appointment', ['id' => 'appointments-form']); ?>

            <input type="text" hidden name="rel_type" value="external">

            <div class="row">

                <div class="col-md-12">

                    <div class="appointment-header"><?php hooks()->do_action('appointly_form_header'); ?></div>

                    <div class="text-center">
                        <h3 class="text-center" style="margin-bottom: 28px"><?= _l('appointment_create_new_appointment'); ?></h3>
                    </div>

                    <?php echo render_input('subject', 'appointment_subject'); ?>

                    <?php $appointment_types = get_appointment_types();

                    if (count($appointment_types) > 0) { ?>
                        <div class="form-group appointment_type_holder">
                            <label for="appointment_select_type"
                                   class="control-label"><?= _l('appointments_type_heading'); ?></label>
                            <select class="form-control selectpicker" name="type_id" id="appointment_select_type">
                                <option value=""><?= _l('dropdown_non_selected_tex'); ?></option>
                                <?php foreach ($appointment_types as $app_type) { ?>
                                    <option class="form-control" data-color="<?= $app_type['color']; ?>"
                                            value="<?= $app_type['id']; ?>"><?= $app_type['type']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class=" clearfix mtop15"></div>
                    <?php } ?>
                    <br>
                    <?php echo render_textarea('description', 'appointment_description', '', ['rows' => 5]); ?>

                    
                    <div class="form-group">
                        <label for="name"><?= _l('appointment_full_name'); ?></label>
                        <input type="text" class="form-control"
                               value="<?= (isset($clientUserData['client_logged_in'])) ? get_contact_full_name($clientUserData['contact_user_id']) : ''; ?>"
                               name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="email"><?= _l('appointment_your_email'); ?></label>
                        <input type="email" class="form-control"
                               value="<?= (isset($clientUserData['client_logged_in'])) ? get_contact_detail($clientUserData['contact_user_id'], 'email') : ''; ?>"
                               name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phone"><?= _l('appointment_phone'); ?>
                            (zB: <?= _l('appointment_your_phone_example'); ?>)</label>
                        <input type="text" class="form-control"
                               value="<?= (isset($clientUserData['client_logged_in'])) ? get_contact_detail($clientUserData['contact_user_id'], 'phonenumber') : ''; ?>"
                               name="phone" id="phone">
                    </div>
                    <div class="hours_wrapper">
                        <span class="available_time_info hwp"><?= _l('appointment_available_hours'); ?></span>
                        <span class="busy_time_info hwp"><?= _l('appointment_busy_hours'); ?></span>
                    </div>
                    <?php echo render_datetime_input('date', 'appointment_date_and_time', '', ['readonly' => "readonly"], [], '', 'appointment-date'); ?>
                    <?php
                    $rel_cf_id = (isset($appointment) ? $appointment['apointment_id'] : false);
                    echo render_custom_fields('appointly', $rel_cf_id);
                    ?>
                    <?php if (
                        get_option('recaptcha_secret_key') != ''
                        && get_option('recaptcha_site_key') != ''
                        && get_option('appointly_appointments_recaptcha') == 1
                    ) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="g-recaptcha"
                                         data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>"></div>
                                    <div id="recaptcha_response_field" class="text-danger"></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="pull-right">
                        <button type="submit" id="form_submit"
                                class="btn btn-primary"><?php echo _l('appointment_submit'); ?></button>
                    </div>
                    <div class="clearfix mtop15"></div>
                </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php
app_external_form_footer($form);
?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span
                    class="copyright-footer"><?= date('Y'); ?>
                    <?= e(_l('clients_copyright', get_option('companyname'))); ?>
                </span>
                <?php if (is_gdpr() && get_option('gdpr_show_terms_and_conditions_in_footer') == '1') { ?>
                - <a href="<?= terms_url(); ?>"
                    class="terms-and-conditions-footer">
                    <?= _l('terms_and_conditions'); ?>
                </a>
                <?php } ?>
                <?php if (is_gdpr() && is_client_logged_in() && get_option('show_gdpr_link_in_footer') == '1') { ?>
                - <a href="<?= site_url('clients/gdpr'); ?>"
                    class="gdpr-footer">
                    <?= _l('gdpr_short'); ?>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>
<?php if (isset($form)): ?>
    <script>
        app.locale = "<?= get_locale_key($form->language); ?>";
    </script>
<?php endif; ?>

<!-- Javascript functionality -->
<?php require('modules/appointly/assets/js/appointments_external_form.php'); ?>

<!-- If callbacks is enabled load on appointments external form -->
<?php if (get_option('callbacks_mode_enabled') == 1) require('modules/appointly/views/forms/callbacks_form.php'); ?>

</body>

</html>