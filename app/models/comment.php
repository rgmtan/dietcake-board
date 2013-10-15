<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 2:56 PM
 * To change this template use File | Settings | File Templates.
 */

class Comment extends AppModel
{
    public $validation = array(
        'username' => array(
            'length' => array(
                'validate_between', 1, 16,
            ),
        ),
        'body' => array(
            'length' => array(
                'validate_between', 1, 200,
            ),
        ),
    );
}