<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph
 * Date: 10/12/13
 * Time: 2:36 PM
 * To change this template use File | Settings | File Templates.
 */

class ThreadController extends AppController
{
    public function index()
    {
        if(!isset($_SESSION['username'])) {
            $this->render('index2');
        }
        $array = Thread::getAll(Param::get('page'));
        $threads = $array[0];

        // pagination parameters
        $rowCount = $array[1];
        $lastPage = $array[2];
        $offset = $array[3];
        $pagenum = $array[4];

        $this->set(get_defined_vars());
    }

    public function view()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $array = $thread->getComments(Param::get('page'));
        $comments = $array[0];

        // pagination parameters
        $rowCount = $array[1];
        $lastPage = $array[2];
        $offset = $array[3];
        $pagenum = $array[4];

        $this->set(get_defined_vars());
    }

    public function write()
    {
        $thread = Thread::get(Param::get('thread_id'));
        $comment = new Comment;
        $page = Param::get('page_next', 'write');
        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');
                try {
                    $thread->write($comment);
                } catch(ValidationException $e) {
                    $page = 'write';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }

    public function create()
    {
        $thread = new Thread;
        $comment = new Comment;
        $page = Param::get('page_next', 'create');
        switch ($page) {
            case 'create':
                break;
            case 'create_end':
                $thread->title = Param::get('title');
                $comment->body = Param::get('body');
                try {
                    $thread->create($comment);
                } catch (ValidationException $e) {
                    $page = 'create';
                }
                break;
            default:
                throw new NotFoundException("{$page} is not found");
                break;
        }
        $this->set(get_defined_vars());
        $this->render($page);
    }
}