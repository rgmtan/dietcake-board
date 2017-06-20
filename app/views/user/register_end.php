<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/13/13
 * Time: 8:30 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<h2>Welcome <?php eh($_SESSION['username']) ?>!</h2>
<p class="alert alert-success">
    Registration successful!
</p>
<a href="<?php eh(url('thread/index')) ?>">Click here to proceed.</a>