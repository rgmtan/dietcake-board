<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 8:41 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<h2>Welcome <?php eh($_SESSION['username']) ?>!</h2>
<p class="alert alert-success">
    You have successfully logged in.
</p>
<a href="<?php eh(url('thread/index')) ?>">Click here to proceed.</a>