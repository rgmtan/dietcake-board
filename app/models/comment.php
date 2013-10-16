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
    const MAX_COMMENTS = 7;
    public $thread_id;

    public $validation = array(
        'body' => array(
            'length' => array(
                'validate_between', 1, 200,
            ),
        ),
    );

    public function getComments($page)
    {
        // if 'page' is NULL, set $page to 1
        if (!isset($page)) {
            $page = 1;
        }
        $comments = array();
        // $rowCount, $lastPage, $offset is used for pagination
        $db = DB::conn();

        $rowCount = $db->value(
            'SELECT COUNT(*) FROM comment WHERE thread_id = ?',
            array($this->thread_id)
        );
        $lastPage = ceil($rowCount/Comment::MAX_COMMENTS);
        $offset = ($page - 1) * Comment::MAX_COMMENTS;

        $db = DB::conn();
        $rows = $db->rows(
            'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC
            LIMIT '.Comment::MAX_COMMENTS.' OFFSET '.$offset,
            array($this->thread_id)
        );
        foreach ($rows as $row) {
            $comments[] = new self ($row);
        }

        return array($comments,$rowCount,$lastPage,$offset,$page);
    }

    public function write()
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->query(
            'INSERT INTO comment SET thread_id = ?, username = ?, body = ?',
            array($this->thread_id, $_SESSION['username'], $this->body)
        );
    }
}