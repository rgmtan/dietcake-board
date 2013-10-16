<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 2:39 PM
 * To change this template use File | Settings | File Templates.
 */

class Thread extends AppModel
{
    const MAX_THREADS = 5;

    public $validation = array(
        'title' => array(
            'length' => array(
                'validate_between', 1, 30,
            ),
        ),
    );
    public static function get($id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        return new self($row);
    }

    public static function getAll($page)
    {
        // if 'page' is NULL, set $page to 1
        if (!isset($page)) {
            $page = 1;
        }
        $threads = array();
        $db = DB::conn();
        // $rowCount, $lastPage, $offset is used for pagination
        $rowCount = $db->value('SELECT COUNT(*) FROM thread');
        $lastPage = ceil($rowCount/Thread::MAX_THREADS);
        $offset = ($page - 1) * Thread::MAX_THREADS;

        $db = DB::conn();
        $rows = $db->rows('SELECT * FROM thread ORDER BY created DESC, id DESC
                            LIMIT '.Thread::MAX_THREADS. ' OFFSET '.$offset
        );
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }

        return array($threads,$rowCount,$lastPage,$offset,$page);
    }

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();

        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('invalid thread or comment');
        }

        $db = DB::conn();
        $db->begin();
        $db->query('INSERT INTO thread SET title = ?, username = ?', array($this->title, $_SESSION['username']));

        $comment->thread_id = $db->lastInsertId();
        // write first comment at the same time
        $comment->write($comment);
        $db->commit();
    }
}