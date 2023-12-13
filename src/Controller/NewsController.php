<?php
namespace Vladyslava\TestoveOop\Controller;

session_start();
use Vladyslava\TestoveOop\Model\News;
use Vladyslava\TestoveOop\Model\User;
use Vladyslava\TestoveOop\View\NewsView;

class NewsController
{
    private News $model;
    private User $userModel;
    private NewsView $view;

    public function __construct(News $model, NewsView $view, User $userModel)
    {
        $this->model = $model;
        $this->view = $view;
        $this->userModel = $userModel;
    }

    public function listNews()
    {
        $news = $this->model->getNews();
        $this->view->renderNews($news);
    }

    public function showCreateForm($message = '')
    {
        $this->view->renderCreateForm($message);
    }

    public function createNews(string $title, string $text, int $authorId)
    {
        try {
            $this->model->createNews($title, $text, $authorId);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function showNews($newsId)
    {
        $news = $this->model->getNewsById($newsId);
        $this->view->renderSingleNews($news, $this->userModel);
    }

    public function editNews($newsId, $message = '')
    {
        $news = $this->model->getNewsById($newsId);
        $this->view->renderEditNews($news, $newsId, $message);
    }

    public function updateNews(int $newsId, string $title, string $text)
    {
        $news = $this->model->getNewsById($newsId);
        if (!$this->userModel->isAuthor($_SESSION['user_id'], $news['author_id'])) {
            header('Location: index.php?action=home');
            exit;
        }
        try {
            $this->model->editNews($newsId, $title, $text);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function deleteNews($newsId)
    {
        $news = $this->model->getNewsById($newsId);
        if (!$this->userModel->isAuthor($_SESSION['user_id'], $news['author_id'])) {
            header('Location: index.php?action=home');
            exit;
        }
        $this->model->deleteNews($newsId);
        header("Location: index.php?action=home");
    }

    public function getHeader()
    {
        $this->view->renderHeader();
    }

    public function getFooter()
    {
        $this->view->renderFooter();
    }
}
