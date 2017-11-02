<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//POST INDEX

//print_r($results);
//print_r($links);

//die;

?>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php echo $pagetitle; ?>
                    <?php echo $breadcrumb; ?>
                </section>
                <section class="content col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo lang('posts_create_category'); ?></h3>
                                </div>
                                <div class="box-body">
                                    <?php echo $message;?>

                                    <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_category')); ?>
                                        <div class="form-group">
                                            <?php echo lang('posts_category_name', 'category_name', array('class' => 'col-sm-12')); ?>
                                            <div class="col-sm-12">
                                                <?php echo form_input($category_name);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('posts_category_description', 'category_description', array('class' => 'col-sm-12')); ?>
                                            <div class="col-sm-12">
                                                <?php echo form_textarea($category_description);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>



                <section class="content col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-body responsivetable">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('posts_category_name');?></th>
                                                <th><?php echo lang('posts_category_slug');?></th>
                                                <th><?php echo lang('posts_category_description');?></th>
                                                <th><?php echo lang('posts_category_count');?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th><?php echo lang('posts_category_name');?></th>
                                                <th><?php echo lang('posts_category_slug');?></th>
                                                <th><?php echo lang('posts_category_description');?></th>
                                                <th><?php echo lang('posts_category_count');?></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
<?php if (!empty($categories)):?>
<?php foreach ($categories as $category):?>
                                            <tr>
                                                <td data-title="<?php echo lang('posts_category_name');?>">
                                                    <?php echo anchor('admin/posts?cat='.$category->category_slug, htmlspecialchars($category->category_name, ENT_QUOTES, 'UTF-8')); ?>
                                                    <fieldset>
                                                        <?php echo anchor('admin/categories/trash/'.$category->category_id, lang('posts_category_trash'),array('class'=>'text text-danger')); ?></fieldset></td>
                                                <td data-title="<?php echo lang('posts_category_slug');?>">
                                                    <?php echo htmlspecialchars($category->category_slug, ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td data-title="<?php echo lang('posts_category_description');?>">
                                                    <?php echo htmlspecialchars($category->category_description, ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td data-title="<?php echo lang('posts_category_count');?>">
                                                    1
                                                </td>
                                            </tr>
<?php endforeach;?>
<?php else:?>
                                            <tr>
                                                <td colspan="4"> No Post Found</td>
                                            </tr>
<?php endif;?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="box-header with-border">
                                    <?php  echo (!empty($links)) ? '<div class="pagination">'.$links.'</div>' : '' ; ?>
                                </div>
                            </div>
                         </div>
                    </div>
                </section>
            </div>
