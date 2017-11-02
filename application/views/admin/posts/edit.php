<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//POST EDIT
?>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo lang('posts_edit_post'); ?></h3>
                                </div>
                                <div class="box-body">
                                    <?php echo $message;?>

                                    <?php echo form_open(uri_string(), array('class' => 'form-horizontal', 'id' => 'form-edit_post')); ?>
                                        <div class="form-group">
                                            <?php echo lang('posts_post_title', 'post_title', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo form_input($post_title);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('posts_post_content', 'post_content', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <?php echo text_editor(array('id'=>'post_content','value'=>$post_content)); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?php echo lang('posts_post_category', 'post_category', array('class' => 'col-sm-2 control-label')); ?>
                                            <div class="col-sm-10">
                                                <div class="row">
                                                <?php foreach ($list_category as $key => $category) { ?>
                                                    <div class="col-sm-4">
                                                        <input type="checkbox" name="post_category[]" value="<?= $category->category_slug; ?>" <?= (in_array($category->category_slug, $post_category)) ? 'checked=checked' : '' ; ?>><?= $category->category_name; ?>
                                                    </div>
                                                <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <?php echo form_hidden('id', $post_id);?>
                                                <?php echo form_hidden($csrf); ?>
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                                    <?php echo anchor('admin/posts', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>
