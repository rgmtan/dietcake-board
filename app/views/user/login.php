<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 7:43 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<?php session_unset(); ?>
<?php if($user->hasError()): ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation Errors!</h4>
        <?php if(!empty($user->validation_errors['username']['length'])): ?>
            <div><em>Username must be</em> between
                <?php eh($user->validation['username']['length'][1]) ?> and
                <?php eh($user->validation['username']['length'][2]) ?>
                characters in length
            </div>
        <?php endif ?>
        <?php if(!empty($user->validation_errors['password']['length'])): ?>
            <div><em>Password must be</em> between
                <?php eh($user->validation['password']['length'][1]) ?> and
                <?php eh($user->validation['password']['length'][2]) ?>
                characters in length
            </div>
        <?php endif ?>
    </div>
<?php endif ?>
<h2>Log In</h2>
<form class="well" method="post" action="<?php eh(url('')) ?>">
    <label>Username</label>
    <input type="text" class="span3" name="username"  value="<?php eh(Param::get('username')) ?>">
    <label>Password</label>
    <input type="password" class="span3" name="password" value="<?php eh(Param::get('password')) ?>">
    <br />
    <input type="hidden" name="page_next" value="login_success">
    <button type="submit" class="btn btn-primary">Log In</button>
    <a class="btn btn-primary" href="<?php eh(url('user/register')) ?>">Register</a>
</form>