<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Project Tasks -->
<?php
    if ($project->settings->hide_tasks_on_main_tasks_table == '1') {
        echo '<i class="fa fa-exclamation fa-2x pull-left" data-toggle="tooltip" data-title="' . _l('project_hide_tasks_settings_info') . '"></i>';
    }
?>
<div class="panel_s">
    <div class="panel-body">
        <div class="tasks-table panel-table-full">
            <?php $this->load->view('task_templates/_task_template_table')?>
        </div>
    </div>
</div>