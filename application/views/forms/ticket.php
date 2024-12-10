<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html dir="<?php echo is_rtl(true) ? 'rtl' : 'ltr'; ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo hooks()->apply_filters('ticket_form_title', _l('new_ticket')); ?></title>
    <?php app_external_form_header($form); ?>
	<?= compile_theme_css(); ?>
	<script
		src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>">
	</script>
    <?php hooks()->do_action('app_ticket_form_head'); ?>
</head>

<body class="ticket_form<?php echo($this->input->get('styled') === '1' ? ' styled' : ''); ?>">
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
                        <div class="<?php echo $this->input->get('col') ? $this->input->get('col') : ($this->input->get('styled') === '1' ? 'col-md-6 col-md-offset-3' : 'col-md-12'); ?>">
                            <div class="form-col">
                                <div id="response"></div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <h1 class="" style="margin-top:0; font-size:22px;">
                                            <div xss="">
                                                <h3 xss=""><b>Du kannst uns jederzeit mit foilgden Anliegen kontaktieren:</b></h3>
                                            </div>
                                        </h1>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="" style="line-height:24px;"></p>
                                        <div><font color=""><span xss=""><span class="" xss="">	</span>•<span class="" xss="">	</span>Support zu JTL-Software oder Ihrem JTL-Shop.</span></font></div>
                                        <div><font color=""><span xss=""><span class="" xss="">	</span>•<span class="" xss="">	</span>Du kannst über diesen Link jederzeit weitere Aufgaben an uns übermitteln.</span></font></div>
                                        <div><font color=""><span xss=""><span class="" xss="">	</span>•<span class="" xss="">	</span>Sollest Du Hilfe benötigen oder Fragen haben, kannst Du dich jederzeit einen Call über folgenden Link reservieren: </span></font></div>
                                        <div><font color=""><span xss=""><span class="" xss="">	</span>•<span class="" xss="">	</span>Kalender Link hier</span></font></div>

                                    <div><br></div>
                                    <div xss=""><p xss=""></p></div>
                                    <div xss=""><p xss="">Nach Rücksprache mit unseren Entwicklern, wird sich einer unserer Mitarbeiter bei Dir melden.</p></div>
                                    <hr>
                                    <div><font color=""><span xss="">	</span><b>sellx GmbH - JTL-Serviceparnter Agentur für 360° E-Commerce Lösungen.</b></span></font></div>
                                    <div><br></div><div><br></div>
                                </div>
                            <hr>
                                <?php echo form_open(current_full_url(), ['id' => 'ticketForm', 'class' => 'disable-on-submit']); ?>
                                <?php hooks()->do_action('ticket_form_start'); ?>

                                <?php echo render_input('subject', 'ticket_form_subject', '', 'text', ['required' => 'true']); ?>
                                <?php hooks()->do_action('ticket_form_after_subject'); ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <?php echo render_input('name', 'ticket_form_name', '', 'text', ['required' => 'true']); ?>
                                        <?php hooks()->do_action('ticket_form_after_name'); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo render_input('email', 'ticket_form_email', '', 'email', ['required' => 'true']); ?>
                                        <?php hooks()->do_action('ticket_form_after_email'); ?>
                                    </div>
                                </div>

                     <?php
                if (get_option('department') && count($departments) >= 0) {
                    echo '<div class="' . ($this->input->get('department_id') == 1 ? 'hide' : '') . '">';
                    echo render_select('department', $departments, ['serviceid', 'name'], 'ticket_form_department', (count($departments) == 1 ? $departments[0]['serviceid'] : $this->input->get('service_id')));
                    echo '</div>';
                    hooks()->do_action('ticket_form_after_department');
                }
                ?>           

                                <?php echo render_select('priority', $priorities, ['priorityid', 'name'], 'ticket_form_priority', hooks()->apply_filters('new_ticket_priority_selected', 2), ['required' => 'true']); ?>
                                <?php hooks()->do_action('ticket_form_after_priority'); ?>

                                <?php
                if (get_option('services') == 1 && count($services) > 0) {
                    echo '<div class="' . ($this->input->get('hide_service') == 1 ? 'hide' : '') . '">';
                    echo render_select('service', $services, ['serviceid', 'name'], 'ticket_form_service', (count($services) == 1 ? $services[0]['serviceid'] : $this->input->get('service_id')));
                    echo '</div>';
                    hooks()->do_action('ticket_form_after_service');
                }
                ?>

                                <?php echo render_custom_fields('tickets', false, ['show_on_ticket_form' => 1]); ?>
                                <?php hooks()->do_action('ticket_form_after_custom_fields'); ?>

                                <?php echo render_textarea('message', 'ticket_form_message', '', ['required' => 'true', 'rows' => 8]); ?>
                                <?php hooks()->do_action('ticket_form_after_message'); ?>

                                <div class="attachments">
                                    <div class="row attachment form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <label for="attachment"
                                                class="control-label"><?php echo _l('ticket_form_attachments'); ?></label>
                                            <div class="input-group">
                                                <input type="file"
                                                    extension="<?php echo str_replace('.', '', get_option('ticket_attachments_file_extensions')); ?>"
                                                    filesize="<?php echo file_upload_max_size(); ?>" class="form-control"
                                                    name="attachments[]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary add_more_attachments"
                                                        data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>"
                                                        type="button"><i class="fa fa-plus"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php hooks()->do_action('ticket_form_after_attachments'); ?>

                                <?php if (show_recaptcha() && $form->recaptcha == 1) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>">
                                            </div>
                                            <div id="recaptcha_response_field" class="text-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <?php if (is_gdpr() && get_option('gdpr_enable_terms_and_conditions_ticket_form') == 1) { ?>
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <div class="checkbox chk">
                                            <input type="checkbox" name="accept_terms_and_conditions" required="true"
                                                id="accept_terms_and_conditions"
                                                <?php echo set_checkbox('accept_terms_and_conditions', 'on'); ?>>
                                            <label for="accept_terms_and_conditions">
                                                <?php echo _l('gdpr_terms_agree', terms_url()); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="clearfix"></div>
                                <div class="text-center submit-btn-wrapper">
                                    <button class="btn btn-success" id="form_submit" type="submit">
                                        <i class="fa fa-spinner fa-spin hide" style="margin-right: 5px;">
                                        </i><?php echo _l('ticket_form_submit'); ?>
                                    </button>
                                </div>

                                <?php hooks()->do_action('ticket_form_after_submit_button'); ?>

                                <?php hooks()->do_action('ticket_form_end'); ?>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    </div>
    <?php app_external_form_footer($form); ?>
    <script>
    var form_id = '#ticketForm';
    $(function() {

        $(form_id).appFormValidator({

            onSubmit: function(form) {

                $("input[type=file]").each(function() {
                    if ($(this).val() === "") {
                        $(this).prop('disabled', true);
                    }
                });
                $('#form_submit .fa-spin').removeClass('hide');

                var formURL = $(form).attr("action");
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: $(form).attr('method'),
                    data: formData,
                    mimeType: $(form).attr('enctype'),
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: formURL
                }).always(function() {
                    $('#form_submit').prop('disabled', false);
                    $('#form_submit .fa-spin').addClass('hide');
                }).done(function(response) {

                    response = JSON.parse(response);
                    // In case action hook is used to redirect
                    if (response.redirect_url) {
                        if (window.top) {
                            window.top.location.href = response.redirect_url;
                        } else {
                            window.location.href = response.redirect_url;
                        }
                        return;
                    }
                    if (response.success == false) {
                        $('#recaptcha_response_field').html(response
                            .message); // error message
                    } else if (response.success == true) {
                        $(form_id).remove();
                        $('#response').html(
                            '<div class="alert alert-success" style="margin-bottom:0;">' +
                            response.message + '</div>');
                        $('html,body').animate({
                            scrollTop: $("#online_payment_form").offset().top
                        }, 'slow');
                    } else {
                        $('#response').html("<?php echo _l('something_went_wrong'); ?>");
                    }
                    if (typeof(grecaptcha) != 'undefined') {
                        grecaptcha.reset();
                    }
                }).fail(function(data) {

                    if (typeof(grecaptcha) != 'undefined') {
                        grecaptcha.reset();
                    }

                    if (data.status == 422) {
                        $('#response').html(
                            '<div class="alert alert-danger">Some fields that are required are not filled properly.</div>'
                        );
                    } else {
                        $('#response').html(data.responseText);
                    }
                });
                return false;
            }
        });
    });
    </script>
    
    <?php hooks()->do_action('app_ticket_form_footer'); ?>
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
</body>

</html>