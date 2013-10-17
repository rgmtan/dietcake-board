<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 10:10 PM
 * To change this template use File | Settings | File Templates.
 */
?>
<?php if (isset($user->username)) : ?>
<?php if($user->hasError() || $user->isUserExisting() ||
          (!is_null($user->rep_password) && $user->isPasswordMatching())) : ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Validation Errors!</h4>
        <?php if($user->isUserExisting()) : ?>
            <div><em>Username exists!</em></div>
        <?php endif ?>
        <?php if($user->isPasswordMatching()) : ?>
            <div><em>Passwords do not match!</em></div>
        <?php endif ?>
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
<?php endif ?>

<h1>User Registration</h1>
<form class="well" method="post" action="#">
    <label>Username</label>
    <input type="text" class="span3" name="username" value="<?php eh(Param::get('username')) ?>">
    <label>Password</label>
    <input type="password" class="span3" name="password" value="<?php eh(Param::get('password')) ?>">
    <label>Repeat Password</label>
    <input type="password" class="span3" name="rep_pass" value="<?php eh(Param::get('rep_pass')) ?>">
    <br />
    <input type="hidden" name="page_next" value="register_end">
    <button type="submit" class="btn btn-primary">Register</button>
    <a class="btn btn-primary" href="<?php eh(url('user/login'))?>">Back</a>
</form>