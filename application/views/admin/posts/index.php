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


                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo anchor('admin/posts/create', '<i class="fa fa-plus"></i> '. lang('posts_create_post'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                                </div>
                                <div class="box-body responsivetable">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><?php echo lang('posts_post_title');?></th>
                                                <th><?php echo lang('posts_post_category');?></th>
                                                <th><?php echo lang('posts_post_created');?></th>
                                                <th><?php echo lang('posts_post_status');?></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th><?php echo lang('posts_post_title');?></th>
                                                <th><?php echo lang('posts_post_category');?></th>
                                                <th><?php echo lang('posts_post_created');?></th>
                                                <th><?php echo lang('posts_post_status');?></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
<?php if (!empty($posts)):?>
<?php foreach ($posts as $post):?>
                                            <tr>
                                                <td data-title="<?php echo lang('posts_post_title');?>">
                                                    <?php echo anchor('admin/posts/edit/'.$post->id, htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8')); ?>
                                                    <fieldset>
                                                        <?php echo anchor('admin/posts/edit/'.$post->id, lang('posts_post_edit')); ?> |
                                                        <?php echo anchor('post/'.$post->slug, lang('posts_post_view')); ?> | 
                                                        <?php echo anchor('admin/posts/trash/'.$post->id, lang('posts_post_trash'),array('class'=>'text text-danger')); ?></fieldset></td>
                                                <td data-title="<?php echo lang('posts_post_category');?>">
                                                    <?php echo implode(',',json_decode($post->post_category)); ?>
                                                </td>
                                                <td data-title="<?php echo lang('posts_post_created');?>">
                                                    <?php echo htmlspecialchars($post->created_date, ENT_QUOTES, 'UTF-8'); ?>
                                                </td>
                                                <td data-title="<?php echo lang('posts_post_status');?>">
                                                    <?php echo ($post->post_status) ? anchor('admin/posts/draft/'.$post->id, '<span class="label label-success">'.lang('posts_post_published').'</span>') : anchor('admin/posts/publish/'. $post->id, '<span class="label label-default">'.lang('posts_post_draft').'</span>'); ?>
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
