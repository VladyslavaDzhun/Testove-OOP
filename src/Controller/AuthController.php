<?php
namespace Vladyslava\TestoveOop\Controller;
session_start();
use Vladyslava\TestoveOop\Model\User;
use Vladyslava\TestoveOop\View\AuthView;
use Vladyslava\TestoveOop\View\NewsView;


class AuthController {
    private User $model;
    private AuthView $view;


    public function __construct(User $model, AuthView $view) {
        $this->model = $model;
        $this->view = $view;
    }


    public function showLoginForm() {
        $this->view->renderLoginForm();
    }


    public function login($username, $password) {
        if ($this->model->validatePassword($username, $password)) {
            // Authentication successful
            header("Location: index.php?action=home");
        } else {
            // Authentication failed
            $this->view->renderLoginForm('Неправильний email або пароль');
        }
    }
    
    public function showRegisterForm() {
        $this->view->renderRegistationForm();
    }
    
    public function register($username, $password, $name) {
        if ($this->model->createUser($username, $password, $name)) {
            // Authentication successful
            header("Location: index.php?action=login");
        } else {
            // Authentication failed
            $this->view->renderRegistationForm('Помилка реєстрації');
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
}
