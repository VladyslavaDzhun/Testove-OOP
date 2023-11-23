<?php
require 'config.php';
require 'DBConnection.php';
require 'vendor/autoload.php';

use Vladyslava\TestoveOop\Controller\AuthController;
use Vladyslava\TestoveOop\Model\User;
use Vladyslava\TestoveOop\View\AuthView;
use Vladyslava\TestoveOop\View\NewsView;
use Vladyslava\TestoveOop\Model\News;
use Vladyslava\TestoveOop\Controller\NewsController;
use Vladyslava\TestoveOop\Controller\CommentsController;
use Vladyslava\TestoveOop\Model\Comments;


$dbConnection = new DBConnection();
$newsController = new NewsController(new News($dbConnection), new NewsView(), new User($dbConnection));
$authController = new AuthController(new User($dbConnection), new AuthView());
$commentsController = new CommentsController(new Comments($dbConnection), new NewsView(), new User($dbConnection));

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
switch ($action) {
    case 'home':
        $newsController->listNews();
        // Displaying the main page
        break;
    case 'login': 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $authController->login( $email,$password);
        }else{
            // User login processing
            $authController->showLoginForm();
        }
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $authController->register( $email,$password, $name);
        }else{
            // User login processing
            $authController->showRegisterForm();
        }
        break;
    case 'create_news':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $text = $_POST['text'];
            $authorId = $_SESSION['user_id'];
            if ($newsController->createNews($title, $text, $authorId)) {
                $message = 'Новину успішно створено';
            } else {
                $message = 'Помилка при створенні новини';
            }
            $newsController->showCreateForm($message);
        }else {
            $newsController->showCreateForm();
        }
        break;
    case 'get_news':
        $newsController->showNews($_GET['id']);
        $commentsController->showCreateCommentForm($_GET['id']);
        $commentsController->ShowComments($_GET['id']);
        break;
    case 'edit_news':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $text = $_POST['text'];
            if ($newsController->updateNews($_GET['news_id'], $title, $text)) {
                $message = 'Новину оновлено';
            } else {
                $message = 'Помилка при оновленні новини';
            }
            $newsController->editNews($_GET['news_id'], $message);
        }else {
            $newsController->editNews($_GET['news_id']);
        }
        break;
    case 'delete_news':
        $newsController->deleteNews($_POST['id']);
        break;
    case 'delete_comment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $commentsController->deleteComment($_POST['id']);
            }
        break;
    case 'edit_comment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = $_POST['text'];
            if($commentsController->updateComments($_GET['comment_id'], $text)) {
                $message = 'Коментар оновлено';
            } else {
                $message = 'Помилка при оновленні коментаря';
            }
            $commentsController->editComments($_GET['comment_id'], $message);
        }else {
        $commentsController->editComments($_GET['comment_id']);
        }
        break;
    case 'create_comment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = $_POST['text'];
            if ($commentsController->createComment($_GET['news_id'],  $text, $_SESSION['user_id'])) {
                $message = 'Коментар успішно створено';
            }else {
                $message = 'Коментар при створенні новини';
            }
            $newsController->showNews($_GET['news_id']);
            $commentsController->showCreateCommentForm($_GET['news_id'],  $message);
            $commentsController->ShowComments($_GET['news_id']);
        }
        break;
    default:
        // Display 404 page if action not found
        include '404.php';
        break;
    }
