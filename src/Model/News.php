<?php
namespace Vladyslava\TestoveOop\Model;
class News {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getNews(){
        $query = "SELECT n.id, n.title, n.text, u.name AS author FROM news n
              INNER JOIN users u ON n.author_id = u.id
              ORDER BY n.publish_date DESC";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function createNews($title, $text, $authorId) {
        $query = "INSERT INTO news (title, text, author_id) VALUES (:title, :newstext, :author)";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':newstext', $text, \PDO::PARAM_STR);
        $stmt->bindParam(':author', $authorId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function getNewsById($newsId) {
        $query = "SELECT n.id, n.title, n.text, n.author_id, u.name AS author FROM news n
            INNER JOIN users u ON n.author_id = u.id
            WHERE n.id = :id";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':id', $newsId, \PDO::PARAM_INT);
        $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    
    }

    public function deleteNews($newsId) {
        $query = "DELETE FROM news WHERE id = :id";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':id', $newsId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function editNews($newsId, $title, $text) {
        $query = "UPDATE news SET title = :title, text = :newstext  WHERE id = :id";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $stmt->bindParam(':newstext', $text, \PDO::PARAM_STR);
        $stmt->bindParam(':id', $newsId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}


