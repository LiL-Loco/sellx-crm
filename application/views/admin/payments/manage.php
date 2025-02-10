<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
    <div class="tw-mb-3">
                    <h4 class="tw-my-0 tw-font-bold tw-text-xl">
                        Zahlungen
                    </h4>
                    <p>
                        Hier findest Du eine Übersicht aller Zahlungen
                    </p>
                </div>
        <div class="panel_s">
            <div class="panel-body">
                <div class="panel-table-full">
                    <?php $this->load->view('admin/payments/table_html'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function() {
        initDataTable('.table-payments', admin_url + 'payments/table', undefined, undefined, 'undefined',
            <?= hooks()->apply_filters('payments_table_default_order', json_encode([0, 'desc'])); ?>
        );
    });
</script>
</body>

</html>