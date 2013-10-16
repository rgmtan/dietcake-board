<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 2:37 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<table class="table table-bordered">
    <th style="background-color: lightblue"><h1>All threads</h1></th>
    <tbody>
    <?php foreach ($threads as $v): ?>
        <tr>
            <td>
                <a href="<?php eh(url('comment/view', array('thread_id' => $v->id))) ?>">
                    <?php eh($v->title) ?>
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
<div class="pager page-header">
    <?php echo $pagination_ctrl; ?>
</div>
<a class="btn btn-primary" href="<?php eh(url('thread/create')) ?>">Create</a>
<?php if(isset($_SESSION['username'])) : ?>
    <a class="btn btn-primary" href="<?php eh(url('user/logout')) ?>">Logout</a>
<?php endif ?>

