<div class="form-group tw-mb-2">
    <?php
    $columns = [
        ['id' => 'name', 'name' => 'Name'],
        ['id' => 'email', 'name' => 'Email'],
        ['id' => 'phone', 'name' => 'Phone'],
        ['id' => 'address', 'name' => 'Address'],
    ];
    ?>
    <?php echo render_select('map_to_column', $columns, ['id', 'name'], _flexform_lang('map_to_column'), $block['map_to_column'], [], [], 'selectpicker'); ?>
</div>