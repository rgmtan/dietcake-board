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
        $comments = array();
        // $rowCount, $lastPage, $offset is used for pagination
        $db = DB::conn();

        $row_count = $db->value(
            'SELECT COUNT(*) FROM comment WHERE thread_id = ?',
            array($this->thread_id)
        );
        $last_page = ceil($row_count/Comment::MAX_COMMENTS);
        $offset = ($page - 1) * Comment::MAX_COMMENTS;

        $rows = $db->rows(
            'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC
            LIMIT '.Comment::MAX_COMMENTS.' OFFSET '.$offset,
            array($this->thread_id)
        );
        foreach ($rows as $row) {
            $comments[] = new self ($row);
        }

        return array(
            'coments' => $comments,
            'last_page' => $last_page,
            'offset' => $offset,
            'pagenum' => $page
        );
    }

    public function write()
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $params = array(
            "thread_id" => $this->thread_id,
            "username" => $_SESSION['username'],
            "body" => $this->body
        );
        $db->insert("comment", $params);
    }
}