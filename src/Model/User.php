<?php
namespace Vladyslava\TestoveOop\Model;
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function validatePassword($username, $password) {
        $stmt = $this->db->getDb()->prepare('SELECT * FROM users WHERE email = :username');
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return $user['id'];
        }


        return false;
    }
    public function createUser($username, $password, $name) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->getDb()->prepare('INSERT INTO users (email, password, name) VALUES (:username, :password, :name)');
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, \PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->getDb()->lastInsertId();
    }

        public function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin ($userId) {
        $query = "SELECT id, role FROM users WHERE id = :id";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($user && $user['role'] === 'admin') {
            return true;
        }

        return false;
    }

    public function isAuthor($userId, $authorId) {
        if($userId === $authorId || $this->isAdmin($userId))
        {
        return true;
    }
        return false;
    }
}

