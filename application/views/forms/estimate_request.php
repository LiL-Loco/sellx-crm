<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?= e($locale); ?>">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?= $title ?? ''; ?></title>
	<?= compile_theme_css(); ?>
	<script
		src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>">
	</script>
	<?php app_customers_head(); ?>
</head>

<body
	class="customers <?= strtolower($this->agent->browser()); ?><?= is_mobile() ? ' mobile' : ''; ?><?= isset($bodyclass) ? ' ' . $bodyclass : ''; ?>"
	<?= $isRTL == 'true' ? 'dir="rtl"' : ''; ?>>
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
                                    <?php echo form_open_multipart($this->uri->uri_string(), ['id' => $form->form_key, 'class' => 'disable-on-submit']); ?>
                                    <?php hooks()->do_action('estimate_request_form_start'); ?>
                                    <?php echo form_hidden('key', $form->form_key); ?>
                                    <div class="form-row">
                                        <?php foreach ($form_fields as $field) {
                                            render_form_builder_field($field);
                                        } ?>
                                        <?php if (show_recaptcha() && $form->recaptcha == 1) { ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="g-recaptcha" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>">
                                                </div>
                                                <div id="recaptcha_response_field" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <?php if (is_gdpr() && get_option('gdpr_enable_terms_and_conditions_estimate_request_form') == 1) { ?>
                                        <div class="col-md-12">
                                            <div class="col-md-12 ">
                                                <div class="checkbox chk">
                                                    <input class="relative" type="checkbox" name="accept_terms_and_conditions"
                                                        required="true" id="accept_terms_and_conditions"
                                                        <?php echo set_checkbox('accept_terms_and_conditions', 'on'); ?>>
                                                    <label for="accept_terms_and_conditions">
                                                        <?php echo _l('gdpr_terms_agree', terms_url()); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="clearfix"></div>
                                        <div class="text-left col-md-12 submit-btn-wrapper">
                                            <button class="btn" id="form_submit" type="submit"
                                                style="color: <?php echo $form->submit_btn_text_color ?>; background-color: <?php echo $form->submit_btn_bg_color ?>;">
                                                <i class="fa fa-spinner fa-spin hide" style="margin-right: 2px;"></i>
                                                <?php echo e($form->submit_btn_name); ?></button>
                                        </div>
                                    </div>
                                    <?php hooks()->do_action('estimate_request_form_end'); ?>
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
    var form_id = '#<?php echo e($form->form_key); ?>';
    var form_redirect_url = '<?php echo $form->submit_action == 1 ? $form->submit_redirect_url : 0; ?>';
    $(function() {
        $(form_id).appFormValidator({
            errorPlacement: function(error, element) {
                if (element.attr("type") == "radio") {
                    error.appendTo(element.parent().parent().parent());
                } else {
                    error.insertAfter(element.parent());
                }
            },
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
                    if (form_redirect_url !== '0') {
                        if (window.top) {
                            window.top.location.href = form_redirect_url;
                        } else {
                            window.location.href = form_redirect_url;
                        }
                        return;
                    } else if (response.redirect_url) {
                        // In case action hook is used to redirect
                        if (window.top) {
                            window.top.location.href = response.redirect_url;
                        } else {
                            window.location.href = response.redirect_url;
                        }
                        return;
                    }
                    if (response.success == false || response.success == 'false') {
                        $('#recaptcha_response_field').html(response
                            .message); // error message
                    } else if (response.success == true || response.success == 'true') {
                        $(form_id).remove();
                        $('#response').html('<div class="alert alert-success">' + response
                            .message + '</div>');
                        $('html,body').animate({
                            scrollTop: $("#<?php echo e($form->form_key); ?>").offset()
                                .top
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