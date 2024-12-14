<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$isGridView = 0;
if ($this->session->has_userdata('cl_grid_view') && $this->session->userdata('cl_grid_view') == 'true') {
    $isGridView = 1;
}
?>
<?php init_head(); ?>
<?php
$customer_type = '';
$clientid = '';
if (isset($call_log) || ($this->input->get('clientid') && $this->input->get('customer_type'))) {
    if ($this->input->get('clientid')) {
        $clientid = $this->input->get('clientid');
        $customer_type = $this->input->get('customer_type');
    } else {
        $clientid = $call_log->clientid;
        $customer_type = $call_log->customer_type;
    }
}

$rel_type = '';
$rel_id = '';
if (isset($call_log) || ($this->input->get('rel_id') && $this->input->get('rel_type'))) {
    if ($this->input->get('rel_id')) {
        $rel_id = $this->input->get('rel_id');
        $rel_type = $this->input->get('rel_type');
    } else {
        $rel_id = $call_log->rel_id;
        $rel_type = (isset($cl_rel_type)) ? $cl_rel_type->key : $call_log->rel_type;
    }
}

$contactid = '';
if (isset($call_log)) {
    $contactid = $call_log->contactid;
}

?>


<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="_buttons">
                                    <?php if (has_permission('call_logs', '', 'create')) { ?>
                                        <a href="<?php echo admin_url('call_logs/call_log'); ?>" class="btn btn-info pull-left display-block mright5"><i class="fa fa-phone menu-icon"></i> <?php echo _l('new_call_log'); ?></a>
                                    <?php } ?>
                                    <a href="<?php echo admin_url('call_logs/overview'); ?>" data-toggle="tooltip" title="<?php echo _l('cl_gantt_overview'); ?>" class="btn btn-default"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php echo _l('cl_overview'); ?></a>
                                    <a href="<?php echo admin_url('call_logs/switch_grid/' . $switch_grid); ?>" class="btn btn-default hidden-xs">
                                        <?php if ($switch_grid == 1) {
                                            echo _l('cl_switch_to_list_view');
                                        } else {
                                            echo _l('cl_switch_to_grid_view');
                                        }; ?>
                                    </a>
                                    <div class="visible-xs">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />

                        <div class="clearfix mtop20"></div>
                        <div class="row" id="call-logs-table">
                            <?php if ($isGridView == 0) { ?>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="bold"><?php echo _l('filter_by'); ?></p>
                                        </div>
                                        <div class="col-md-2 cl-filter-column">
                                            <?php echo render_select('view_assigned', $staffs, array('staffid', array('firstname', 'lastname')), '', '', array('data-width' => '100%', 'data-none-selected-text' => _l('cl_filter_staff')), array(), 'no-mbot'); ?>
                                        </div>
                                        <div class="col-md-2 cl-filter-column">
                                            <?php echo render_select('view_by_rel_type', $rel_types, array('id', array('name')), '', '', array('data-width' => '100%', 'data-none-selected-text' => _l('cl_type')), array(), 'no-mbot'); ?>
                                        </div>
                                        <div class="col-md-2 cl-filter-column">
                                            <?php echo render_select('view_by_lead', $leads, array('id', array('name')), '', '', array('data-width' => '100%', 'data-none-selected-text' => _l('cl_lead')), array(), 'no-mbot'); ?>
                                        </div>
                                        <div class="col-md-2 cl-filter-column">
                                            <?php echo render_select('view_by_customer', $clcustomers, array('userid', array('company')), '', '', array('data-width' => '100%', 'data-none-selected-text' => _l('cl_customer')), array(), 'no-mbot'); ?>
                                        </div>
                                        <div class="col-md-2 cl-filter-column">
                                            <?php echo render_select('view_by_status', $cl_filter_status, array('id', array('name')), '', '', array('data-width' => '100%', 'data-none-selected-text' => _l('cl_filter_status')), array(), 'no-mbot'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <hr class="hr-panel-heading" />
                            <?php } ?>

                            <div class="col-md-12">
                                <?php if ($this->session->has_userdata('cl_grid_view') && $this->session->userdata('cl_grid_view') == 'true') { ?>
                                    <div class="grid-tab" id="grid-tab">
                                        <div class="row">
                                            <div id="cl-grid-view" class="container-fluid">

                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php render_datatable(array(
                                        _l('cl_type'),
                                        _l('cl_purpose_of_call'),
                                        _l('cl_caller'),
                                        _l('cl_contact'),
                                        _l('cl_start_time'),
                                        _l('cl_end_time'),
                                        _l('cl_duration'),
                                        _l('cl_call_follow_up'),
                                        _l('cl_is_important'),
                                        _l('cl_is_completed'),
                                        _l('cl_opt_event_type'),
                                    ), 'call_logs'); ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Call Log Modal-->
<div class="modal fade call_log-modal" id="call_log-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content data">

        </div>
    </div>
</div>
<div class="modal fade" id="send_bulk_sms_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel_s">
                            <div class="panel-body">
                                <h4 class="no-margin">Add new</h4>
                                <hr class="hr-panel-heading">
                                <div class="form-group select-placeholder">
                                    <label for="customer_type" class="control-label"> <?php echo _l('cl_related'); ?></label>
                                    <select name="customer_type" id="customer_type" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""></option>
                                        <option value="lead" <?php if ((isset($call_log) && $call_log->customer_type == 'lead') || $this->input->get('customer_type')) {
                                                                    if ($customer_type == 'lead') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>><?php echo _l('cl_lead'); ?></option>
                                        <option value="customer" <?php if ((isset($call_log) &&  $call_log->customer_type == 'customer') || $this->input->get('customer_type')) {
                                                                        if ($customer_type == 'customer') {
                                                                            echo 'selected';
                                                                        }
                                                                    } ?>><?php echo _l('cl_customer'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group select-placeholder<?php if ($clientid == '') {
                                                                                echo ' hide';
                                                                            } ?> " id="clientid_wrapper">
                                    <label for="clientid"><span class="clientid_label"></span></label>
                                    <div id="clientid_select">
                                        <select name="clientid" id="clientid" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" onchange="myFunction()" multiple>
                                            <?php if ($clientid != '' && $customer_type != '') {
                                                $rel_data = get_relation_data($customer_type, $clientid);
                                                $rel_val = get_relation_values($rel_data, $customer_type);
                                                echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group select-placeholder <?php if ($contactid == '') {
                                                                                echo ' hide';
                                                                            } ?> " id="contactid_wrapper">
                                    <label for="contactid"><span class="contactid_label">Contact</span></label>
                                    <div id="contactid_select">
                                        <select name="contactid" id="contactid" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" onchange="myFunction2()" multiple>
                                            <?php
                                            if ($contactid != '') {
                                                echo '<option value="' . $call_log->contactid . '" selected>' . $call_log->contact_name . ' - ' . $call_log->contact_email . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                $selected = (isset($call_log) ? $call_log->rel_type : '');
                                if (is_admin() || get_option('staff_members_create_inline_cl_types') == '1') {
                                    echo render_select_with_input_group('rel_type', $rel_types, array('id', 'name'), 'cl_type', $selected, '<a href="#" onclick="new_cl_type();return false;"><i class="fa fa-plus"></i></a>');
                                } else {
                                    echo render_select('rel_type', $rel_types, array('id', 'name'), 'cl_type', $selected);
                                } ?>
                                <div class="form-group select-placeholder<?php if ($rel_type != 'proposal' && $rel_type != 'estimate') {
                                                                                echo ' hide';
                                                                            } ?> " id="rel_id_wrapper">
                                    <label for="rel_id"><span class="rel_id_label"></span></label>
                                    <div id="rel_id_select">
                                        <select name="rel_id" id="rel_id" class="ajax-search" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                            <?php if ($rel_id != '' && $rel_type != '') {
                                                $rel_data = get_relation_data($rel_type, $rel_id);
                                                $rel_val = get_relation_values($rel_data, $rel_type);
                                                echo '<option value="' . $rel_val['id'] . '" selected>' . $rel_val['name'] . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php $value = (isset($call_log) ? $call_log->call_purpose : ''); ?>

                                <?php $value = (isset($call_log) ? $call_log->call_summary : ''); ?>

                                <div class="form-group follow_up_wrapper" app-field-wrapper="has_follow_up">
                                    <div class="">
                                        <span><?php echo _l('cl_follow_up_requried'); ?></span>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" value="1" id="has_follow_1" name="has_follow_up" <?php if (isset($call_log) && $call_log->has_follow_up == 1) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                            <label for="has_follow_1"><?php echo _l('cl_follow_up_yes'); ?></label>
                                        </div>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" value="0" id="has_follow_0" name="has_follow_up" <?php if (isset($call_log) && $call_log->has_follow_up == 0) {
                                                                                                                        echo 'checked';
                                                                                                                    } else if (!isset($call_log)) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                            <label for="has_follow_0"><?php echo _l('cl_follow_up_no'); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group followup-schedule <?php if (!isset($call_log) || $call_log->has_follow_up == 0) {
                                                                                echo 'hide';
                                                                            } ?>">
                                    <?php $value = ((isset($call_log) && $call_log->follow_up_schedule != '') ? _d($call_log->follow_up_schedule) : _d(date('Y-m-d H:i'))) ?>
                                    <?php echo render_datetime_input('follow_up_schedule', 'cl_follow_up_schedule', $value, ['readonly' => 'readonly']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12" id="cl_call_duration_div" style="display: none;">
                            <?php $value = (isset($call_log) ? $call_log->call_duration : '') ?>
                            <?php echo render_input('call_duration', 'cl_call_duration', $value, 'text', ["readonly" => "readonly"]); ?>
                        </div>
                        <div class="col-md-12">
                            <?php echo render_input('staffid', '', get_staff_user_id(), 'hidden'); ?>
                            <?php echo render_input('staff_email', 'cl_call_owner', $owner->firstname . ' ' . $owner->lastname, 'text', ['disabled' => 'disabled']); ?>
                            <?php
                            $i = 0;
                            $selected = '';
                            foreach ($staff as $member) {
                                if ($member['staffid'] == get_staff_user_id()) {
                                    continue;
                                }
                                if (isset($call_log)) {
                                    if ($call_log->call_with_staffid == $member['staffid']) {
                                        $selected = $member['staffid'];
                                    }
                                }
                                $i++;
                            }
                            echo render_select('call_with_staffid', $staff, array('staffid', array('firstname', 'lastname')), 'cl_call_with_staff', $selected);
                            ?>
                        </div>

                        <div class="col-md-12">
                            <div class="">
                                <span><?php echo _l('cl_call_log_completed'); ?></span>
                                <div class="radio radio-primary radio-inline">
                                    <input type="radio" value="1" id="is_completed_1" name="is_completed" <?php if (isset($call_log) && $call_log->is_completed == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    <label for="is_completed_1"><?php echo _l('cl_follow_up_yes'); ?></label>
                                </div>
                                <div class="radio radio-primary radio-inline">
                                    <input type="radio" value="0" id="is_completed_0" name="is_completed" <?php if (isset($call_log) && $call_log->is_completed == 0) {
                                                                                                                echo 'checked';
                                                                                                            } else if (!isset($call_log)) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    <label for="is_completed_0"><?php echo _l('cl_follow_up_no'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="">
                                <span><?php echo _l('cl_call_log_important'); ?>&nbsp;&nbsp;</span>
                                <div class="radio radio-primary radio-inline">
                                    <input type="radio" value="1" id="is_important_1" name="is_important" <?php if (isset($call_log) && $call_log->is_important == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    <label for="is_important_1"><?php echo _l('cl_follow_up_yes'); ?></label>
                                </div>
                                <div class="radio radio-primary radio-inline">
                                    <input type="radio" value="0" id="is_important_0" name="is_important" <?php if (isset($call_log) && $call_log->is_important == 0) {
                                                                                                                echo 'checked';
                                                                                                            } else if (!isset($call_log)) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                    <label for="is_important_0"><?php echo _l('cl_follow_up_no'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="lead_id" id="lead_id">
        <input type="hidden" id="customer_id">
        <?php echo form_close(); ?>
    </div>
    <div class="btn-bottom-pusher"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-info save-cl"><?php echo _l('submit'); ?></button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>




<?php $this->load->view('call_types/type.php'); ?>
<?php $this->load->view('call_types/call_direction.php'); ?>
<?php init_tail(); ?>


<?php if ($contactid != ''): ?>
    <script type="text/javascript">
        $(function() {
            init_ajax_search('contactid', $('#contactid'), {
                clientid: $('#clientid').val()
            }, admin_url + 'call_logs/get_contact');
        })
    </script>
<?php endif ?>
<script>
    var userphone = [];
    var _lnth = 13;
    $(function() {
        var TblServerParams = {
            "assigned": "[name='view_assigned']",
            "view_by_rel_type": "[name='view_by_rel_type']",
            "view_by_lead": "[name='view_by_lead']",
            "view_by_customer": "[name='view_by_customer']",
            "view_by_status": "[name='view_by_status']",
        };

        if (<?php echo $isGridView ?> == 0) {
            var tAPI = initDataTable('.table-call_logs', admin_url + 'call_logs/table', [], [2, 3], TblServerParams, [4, 'desc']);
            $.each(TblServerParams, function(i, obj) {
                $('select' + obj).on('change', function() {
                    $('table.table-call_logs').DataTable().ajax.reload()
                        .columns.adjust()
                        .responsive.recalc();
                });
            });
        } else {
            $('.bootstrap-select').on('click', function(e) {
                $(this).toggleClass('open');
            });
            $('#clientid_select').on('click', function() {
                $(this).find('div.bootstrap-select').toggleClass('open');

            });
            $('#contactid_select').on('click', function() {
                $(this).find('div.bootstrap-select').toggleClass('open');
            });
            loadGridView();

            $(document).off().on('click', 'a.paginate', function(e) {
                e.preventDefault();
                console.log("$(this)", $(this).data('ci-pagination-page'))
                var pageno = $(this).data('ci-pagination-page');
                var formData = {
                    search: $("input#search").val(),
                    start: (pageno - 1),
                    length: _lnth,
                    draw: 1
                }
                gridViewDataCall(formData, function(resposne) {
                    $('div#grid-tab').html(resposne)
                })
            });
        }
    });



    var _clientid = $('#clientid'),
        _customer_type = $('#customer_type'),
        _clientid_wrapper = $('#clientid_wrapper'),
        data = {};

    var _rel_id = $('#rel_id'),
        _rel_type = $('#rel_type'),
        _rel_id_wrapper = $('#rel_id_wrapper');

    $(function() {
        $('body').on('click', 'button.save-cl', function() {
            $("#call_end_time").trigger('blur');
        });

        $('body').on('change', '#clientid', function() {
            initRelIdCntrl();
        });
        validate_call_log_form();
        $('.clientid_label').html(_customer_type.find('option:selected').text());
        _customer_type.on('change', function() {
            userphone = [];
            var clonedSelect = _clientid.html('').clone();
            _clientid.selectpicker('destroy').remove();
            _clientid = clonedSelect;
            $('#clientid_select').append(clonedSelect);
            call_log_clientid_select();
            _rel_id.trigger('change');
            if ($(this).val() != '') {
                _clientid_wrapper.removeClass('hide');
            } else {
                _clientid_wrapper.addClass('hide');
            }
            $('.clientid_label').html(_customer_type.find('option:selected').text());

            initRelIdCntrl();
        });
        call_log_clientid_select();

        <?php if (!isset($call_log) && $clientid != '') { ?>
            _clientid.change();
        <?php } ?>

        $('.rel_id_label').html(_rel_type.find('option:selected').text());
        _rel_type.on('change', function() {

            var clonedSelect = _rel_id.html('').clone();
            _rel_id.selectpicker('destroy').remove();
            _rel_id = clonedSelect;
            $('#rel_id_select').append(clonedSelect);
            call_log_rel_id_select();
            if ($(this).val() == '1' || $(this).val() == '2') {

                _rel_id_wrapper.removeClass('hide');
            } else {
                _rel_id_wrapper.addClass('hide');
            }
            $('.rel_id_label').html(_rel_type.find('option:selected').text());
        });
        call_log_rel_id_select();
        <?php if (!isset($call_log) && $rel_id != '') { ?>
            _rel_id.change();
        <?php } ?>

        $("input[type='radio'][name='has_follow_up']").change(function() {
            if ($('input[type="radio"][name="has_follow_up"]:checked').val() == 1) {
                $('div.followup-schedule').removeClass('hide');
            } else {
                $('div.followup-schedule').addClass('hide');
            }
        });

        $("#call_start_time").blur(function() {
            calculate_duration($(this).val(), $('#call_end_time').val());
        });
        $("#call_end_time").blur(function() {
            calculate_duration($('#call_start_time').val(), $(this).val());
        });
    });

    function calculate_duration(start_time, end_time) {
        $.ajax({
            url: admin_url + 'call_logs/calculate_duration',
            type: 'POST',
            data: {
                start_time: start_time,
                end_time: end_time
            },
            success: function(result) {
                $("#call_duration").val(result)
            }
        });
    }

    function initRelIdCntrl() {
        var clonedSelect = _rel_id.html('').clone();
        _rel_id.selectpicker('destroy').remove();
        _rel_id = clonedSelect;
        $('#rel_id_select').append(clonedSelect);
        call_log_rel_id_select();
        if (_rel_type.find('option:selected').val() != '') {
            _rel_id_wrapper.removeClass('hide');
        } else {
            _rel_id_wrapper.addClass('hide');
        }
        $('.rel_id_label').html(_rel_type.find('option:selected').text());
    }

    function call_log_clientid_select() {
        var serverData = {};
        serverData.clientid = _clientid.val();
        data.type = _customer_type.val();
        init_ajax_search(_customer_type.val(), _clientid, serverData);
    }

    function call_log_rel_id_select() {
        var serverData = {};
        serverData.rel_type = $('#customer_type').children("option:selected").val();
        serverData.rel_id = _clientid.val();
        var cl_rel_type = '';

        if (_rel_type.val() == 1) {
            cl_rel_type = 'proposal';
        } else if (_rel_type.val() == 2) {
            cl_rel_type = 'estimate';
        } else {
            cl_rel_type = _rel_type.val();
        }

        data.type = cl_rel_type;
        init_ajax_search(cl_rel_type, _rel_id, serverData, admin_url + 'call_logs/get_relation_data');
    }

    function convertTime(sec) {
        var hours = Math.floor(sec / 3600);
        (hours >= 1) ? sec = sec - (hours * 3600): hours = '00';
        var min = Math.floor(sec / 60);
        (min >= 1) ? sec = sec - (min * 60): min = '00';
        (sec < 1) ? sec = '00': void 0;
        (min.toString().length == 1) ? min = '0' + min: void 0;
        (sec.toString().length == 1) ? sec = '0' + sec: void 0;
        return hours + ':' + min + ':' + sec;
    }
</script>
</body>

</html>