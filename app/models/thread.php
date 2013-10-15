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
    const MAX_COMMENTS = 7;

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
        if(!isset($page)) {
            $page = 1;
        }
        $threads = array();
        $db = DB::conn();
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

    public function getComments($page)
    {
        if(!isset($page)) {
            $page = 1;
        }
        $comments = array();
        $db = DB::conn();
        $rowCount = $db->value(
            'SELECT COUNT(*) FROM comment WHERE thread_id = ?',
            array($this->id)
        );
        $lastPage = ceil($rowCount/Thread::MAX_COMMENTS);
        $offset = ($page - 1) * Thread::MAX_COMMENTS;

        $db = DB::conn();
        $rows = $db->rows(
            'SELECT * FROM comment WHERE thread_id = ? ORDER BY created ASC
            LIMIT '.Thread::MAX_COMMENTS.' OFFSET '.$offset,
            array($this->id)
        );
        foreach ($rows as $row) {
            $comments[] = new Comment($row);
        }

        return array($comments,$rowCount,$lastPage,$offset,$page);
    }

    public function write(Comment $comment)
    {
        if (!$comment->validate()) {
            throw new ValidationException('invalid comment');
        }
        $db = DB::conn();
        $db->query(
            'INSERT INTO comment SET thread_id = ?, username = ?, body = ?, created = NOW()',
            array($this->id, $_SESSION['username'], $comment->body)
        );
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
        $db->query('INSERT INTO thread SET title = ?, username = ?, created = NOW()', array($this->title, $_SESSION['username']));

        $this->id = $db->lastInsertId();
        // write first comment at the same time
        $this->write($comment);
        $db->commit();
    }
}