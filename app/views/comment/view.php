<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 2:55 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<table class="table table-bordered">
    <th style="background-color: lightblue"><h1><?php eh($thread->title) ?></h1></th>
    <?php foreach ($comments as $k => $v): ?>
        <tr>
            <td><span style="color:darkred">Post # </span><?php eh($k + 1) ?></td>
            <td>
                <span style="color:blue"><?php eh($v->username) ?></span> :
                <?php echo readable_text($v->body) ?>
            </td>
            <td><span style="color:blue">Posted on : </span><?php eh($v->created) ?></td>
        </tr>
    <?php endforeach ?>
</table>
<hr>
<div class="pager page-header">
    <?php echo $pagination_ctrl; ?>
</div>
<form class="well" method="post" action="<?php eh(url('comment/write')) ?>">
    <label>Comment</label>
    <textarea name="body"><?php eh(Param::get('body')) ?></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-primary" href="<?php eh(url('thread/index')) ?>">Back</a>
</form>

