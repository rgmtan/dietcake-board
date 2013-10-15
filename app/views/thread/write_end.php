<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 3:15 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<h2><?php eh($thread->title) ?></h2>
<p class="alert alert-success">
    You successfully wrote this comment.
</p>
<a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">
    &larr; Back to thread
</a>