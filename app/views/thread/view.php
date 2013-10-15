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
    <?php
    // If there is more than 1 page of results
    if($lastPage != 1) :
        /**
         * Checks if we're on page 1. If yes, then we don't need a link
         * to the previous page or the first page. If not, we generate
         * links to the first page, and to the previous page.
         * */
        if($pagenum > 1) : $previous = $pagenum - 1; ?>
            <a href="<?php eh(url('',array('page' => $previous)))?>">Previous</a>
            <?php
            // Renders links of pages.
            for($i = $pagenum - 4; $i < $pagenum; $i++) : if($i > 0) : ?>
                <a href="<?php eh(url('',array('page' => $i)))?>"><?php echo $i ?></a>
            <?php endif; endfor; ?>
        <?php endif;
        // render the target pagenum but without it being a link
        echo $pagenum ?>
        <?php
        // Render links of pages.
        for($i = $pagenum + 1; $i <= $lastPage; $i++) : ?>
            <a href="<?php eh(url('',array('page' => $i)))?>"><?php echo $i ?></a>
            <?php if($i >= $pagenum + 4) : break; endif ?>
        <?php endfor ?>
        <?php
        // Same as above but instead, checks if we're on the last page and generate next link.
        if($pagenum != $lastPage) : $next = $pagenum + 1; ?>
            <a href="<?php eh(url('',array('page' => $next)))?>">Next</a>
        <?php endif ?>
    <?php endif ?>
</div>
<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
    <label>Comment</label>
    <textarea name="body"><?php eh(Param::get('body')) ?></textarea>
    <br />
    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a class="btn btn-primary" href="<?php eh(url('thread/index')) ?>">Back</a>
</form>

