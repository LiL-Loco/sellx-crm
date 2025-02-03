<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="justify-content-center row mt-5">
    <div class="col-xl-5">
        <div class="auth-card card">
            <div class="px-3 py-5 card-body">
                <div class="px-4">
                    <div class="mx-auto mb-4 text-center auth-logo">
                        <a href="https://kundenportal.sellx.studio/" class="logo-dark">
                            <img src="https://kundenportal.sellx.studio/uploads/company/cbb7dea1b43ac5f6912c33527786eac4.png" height="32" alt="sellx GmbH">
                        </a>
                    </div>
                    <h2 class="fw-bold text-uppercase text-center fs-18">Einloggen</h2>
                    <p class="text-muted text-center mt-1 mb-4">E-Mail-Adresse und Passwort eingeben, um auf das Kundenportal zuzugreifen.</p>
                </div>
                <div class="px-4">
                    <?= form_open($this->uri->uri_string(), ['class' => 'authentication-form login-form']); ?>
                    <?php hooks()->do_action('clients_login_form_start'); ?>

                    <div class="mb-3">
                        <div>
                            <label for="email" class="form-label"><?= _l('clients_login_email'); ?></label>
                            <input type="text" autofocus="true" class="bg-light bg-opacity-50 border-light py-2 form-control" name="email" id="email">
                            <?= form_error('email'); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a class="float-end text-muted text-unline-dashed ms-1" href=<?= site_url('authentication/forgot_password'); ?></a>Passwort vergessen?</a>
                        <div>
                            <label for="password" class="form-label"><?= _l('clients_login_password'); ?></label>
                            <input type="password" class="bg-light bg-opacity-50 border-light py-2 form-control" name="password" id="password">
                            <?= form_error('password'); ?>
                        </div>
                    </div>

                    <?php if (show_recaptcha_in_customers_area()) { ?>
                        <div class="g-recaptcha tw-mb-4"
                            data-sitekey="<?= get_option('recaptcha_site_key'); ?>">
                        </div>
                        <?= form_error('g-recaptcha-response'); ?>
                    <?php } ?>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember">
                                <?= _l('clients_login_remember'); ?>
                            </label>
                        </div>
                    </div>

                    <div class="form-group tw-mt-6">
                        <button type="submit" class="btn btn-primary btn-block">
                            <?= _l('clients_login_login_string'); ?>
                        </button>
                        <?php if (get_option('allow_registration') == 1) { ?>
                            <a href="<?= site_url('authentication/register'); ?>"
                                class="btn btn-default btn-block">
                                <?= _l('clients_register_string'); ?>
                            </a>
                        <?php } ?>
                    </div>
                    <?php hooks()->do_action('clients_login_form_end'); ?>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>