<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ralph Tan
 * Date: 10/16/13
 * Time: 10:24 AM
 * To change this template use File | Settings | File Templates.
 */

class CommentController extends AppController
{
    public function view()
    {
        $comment = new Comment;
        $thread_id = Param::get('thread_id');
        $thread = Thread::get($thread_id);
        $comment->thread_id = $thread_id;
        $array = $comment->getComments(Param::get('page',1));
        $comments = $array['comments'];

        // pagination parameters
        $last_page = $array['last_page'];
        $offset = $array['offset'];
        $pagenum = $array['pagenum'];

        $pagination_ctrl = pagination($last_page, $pagenum);
        $this->set(get_defined_vars());
    }

    public function write()
    {
        $comment = new Comment;
        $thread_id = Param::get('thread_id');
        $thread = Thread::get($thread_id);
        $comment->thread_id = $thread_id;
        $page = Param::get('page_next', 'write');
        switch ($page) {
            case 'write':
                break;
            case 'write_end':
                $comment->body = Param::get('body');
                try {
                    $comment->write($comment);
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
}