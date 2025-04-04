<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade _project_file" tabindex="-1" role="dialog" data-toggle="modal">
   <div class="modal-dialog full-screen-modal" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" onclick="close_modal_manually('._project_file'); return false;"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo $file->subject; ?></h4>
         </div>
         <div class="modal-body">
               <div class="project_file_area">
                   <?php
                   if ($file->staffid == get_staff_user_id() || has_permission('projects', '', 'create')) {
                       ?>
                       <?php echo render_input('file_subject', 'project_discussion_subject', $file->subject, 'text', ['onblur' => 'update_template_file_data(' . $file->id . ')']); ?>
                       <?php echo render_textarea('file_description', 'project_discussion_description', $file->description, ['onblur' => 'update_template_file_data(' . $file->id . ')']); ?>
                       <hr />
                       <?php
                   } else {
                       ?>
                       <?php if (!empty($file->description)) {
                           ?>
                           <p class="bold"><?php echo _l('project_discussion_description'); ?></p>
                           <p class="text-muted"><?php echo $file->description; ?></p>
                           <hr />
                           <?php
                       } ?>
                       <?php
                   } ?>

                  <?php if (!empty($file->external) && $file->external == 'dropbox') {
                         ?>
                     <a href="<?php echo $file->external_link; ?>" target="_blank" class="btn btn-primary mbot20">
                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                        <?php echo _l('open_in_dropbox'); ?>
                     </a>
                     <br />
                  <?php
                     } elseif (!empty($file->external) && $file->external == 'gdrive') {
                         ?>
                     <a href="<?php echo $file->external_link; ?>" target="_blank" class="btn btn-primary mbot20">
                           <i class="fa-brands fa-google" aria-hidden="true"></i>
                           <?php echo _l('open_in_google'); ?>
                     </a>
                     <br />
                  <?php
                     } ?>
                  <?php
                     $path = PROJECT_TEMPLATES_ATTACHMENTS_FOLDER . $file->project_template_id . '/' . $file->file_name;
                    $url = prepare_project_template_file_url($file->project_template_id, $file->file_name);
                     if (is_image($path)) {
                         ?>
                  <img src="<?php echo $url; ?>" class="img img-responsive">
                  <?php
                     } elseif (!empty($file->external) && !empty($file->thumbnail_link) && $file->external == 'dropbox') {
                         ?>
                  <img src="<?php echo optimize_dropbox_thumbnail($file->thumbnail_link); ?>" class="img img-responsive">
                  <?php
                     } elseif (strpos($file->filetype, 'pdf') !== false && empty($file->external)) {
                         ?>
                  <iframe src="<?php echo $url; ?>" height="100%" width="100%" frameborder="0"></iframe>
                  <?php
                     } elseif (is_html5_video($path)) {
                         ?>
                  <video width="100%" height="100%" src="<?php echo site_url('download/preview_video?path=' . protected_file_url_by_path($path) . '&type=' . $file->filetype); ?>" controls>
                     Your browser does not support the video tag.
                  </video>
                  <?php
                     } elseif (is_markdown_file($path) && $previewMarkdown = markdown_parse_preview($path)) {
                         echo $previewMarkdown;
                     } else {
                         if (empty($file->external)) {
                             echo '<a href="' . $url . '" download="' . $file->original_file_name . '">' . $file->file_name . '</a>';
                         } else {
                             echo '<a href="' . $file->external_link . '" target="_blank">' . $file->file_name . '</a>';
                         }
                         echo '<p class="text-muted">' . _l('no_preview_available_for_file') . '</p>';
                     } ?>
               </div>
         </div>
         <div class="clearfix"></div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="close_modal_manually('._project_file'); return false;"><?php echo _l('close'); ?></button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php $discussion_lang = get_project_discussions_language_array(); ?>
<script>
 var discussion_id = '<?php echo $file->id; ?>';
 var discussion_user_profile_image_url = '<?php echo $discussion_user_profile_image_url; ?>';
 var current_user_is_admin = '<?php echo is_admin(); ?>';
 $('body').find('._project_file').modal({show:true, backdrop:'static', keyboard:false});
</script>
