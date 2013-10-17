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
        $threads = array();
        $db = DB::conn();
        // $row_count, $last_page, $offset is used for pagination
        $row_count = $db->value('SELECT COUNT(*) FROM thread');
        $last_page = ceil($row_count/Thread::MAX_THREADS);
        $offset = ($page - 1) * Thread::MAX_THREADS;

        $rows = $db->rows('SELECT * FROM thread ORDER BY created DESC, id DESC
                            LIMIT '.Thread::MAX_THREADS. ' OFFSET '.$offset
        );
        foreach ($rows as $row) {
            $threads[] = new Thread($row);
        }

        return array(
            'threads' => $threads,
            'last_page' => $last_page,
            'offset' => $offset,
            'pagenum' => $page
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
        $params = array(
            "title" => $this->title,
            "username" => $_SESSION['username']
        );
        $db->insert("thread", $params);

        $comment->thread_id = $db->lastInsertId();
        // write first comment at the same time
        $comment->write($comment);
        $db->commit();
    }
}