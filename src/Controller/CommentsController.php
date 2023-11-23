<?php
namespace Vladyslava\TestoveOop\Controller;
session_start();
use Vladyslava\TestoveOop\Model\Comments;
use Vladyslava\TestoveOop\Model\User;
use Vladyslava\TestoveOop\View\NewsView;

class CommentsController {
    private Comments $commentsModel;
    private User $userModel;
    private NewsView $view;

    public function __construct(Comments $commentsModel,  NewsView $view, User $userModel)
    {
        $this->commentsModel = $commentsModel;
        $this->view = $view;
        $this->userModel = $userModel;
    }

    public function ShowComments($newsId) {
        $comments = $this->commentsModel->getCommentsByNewsId($newsId);
        $this->view->renderComments($comments, $this->userModel);
    }

    public function showCreateCommentForm($newsId, $message = '')
    {
        $this->view->createComments($newsId, $message);
    }

     public function createComment($newsId, string $content, int $authorId)
    {
        try {
            $this->commentsModel->createComment($newsId, $content, $authorId);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    public function updateComments(int $commentsId, string $text) {
        $comment = $this->commentsModel->getCommentsById($commentsId);
        if (!$this->userModel->isAuthor($_SESSION['user_id'], $comment['author_id']) ) {
            header('Location: index.php?action=home');
            exit;
        }
        try {
        $this->commentsModel->editComments($commentsId, $text);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function editComments($commentsId, $message = '') {
        $comment = $this->commentsModel->getCommentsById($commentsId);
        $this->view->updateComments($commentsId, $comment, $message);
    }

    public function deleteComment($commentsId) {
        $comment = $this->commentsModel->getCommentsById($commentsId);
        if (!$this->userModel->isAuthor($_SESSION['user_id'], $comment['author_id']) ) {
            header('Location: index.php?action=home');
            exit;
        }
        $this->commentsModel->deleteComment($commentsId);
        header('Location: index.php?action=get_news&id='.$comment['news_id']);
    }
    
}
