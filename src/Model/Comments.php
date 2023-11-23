<?php
namespace Vladyslava\TestoveOop\Model;

class Comments {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCommentsByNewsId($newsId) {
        $query = "SELECT c.id, c.text, c.author_id, u.name AS author FROM comments c
        INNER JOIN users u ON c.author_id = u.id
        WHERE c.news_id = :news_id
        ORDER BY c.created_at DESC";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':news_id', $newsId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createComment($newsId, $content, $authorId)
    {
        $query = "INSERT INTO comments (news_id, text, author_id) VALUES (:news_id, :content, :author)";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':news_id', $newsId, \PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $stmt->bindParam(':author', $authorId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCommentsById($commentsId) {
        $query = "SELECT * from comments WHERE id = :commentId";
        $stmt = $this->db->getDb()->prepare($query);
        $stmt->bindParam(':commentId', $commentsId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function deleteComment($commentsId) {
        $query = "DELETE FROM comments WHERE id = :commentId";
        $stmt =  $this->db->getDb()->prepare($query);
        $stmt->bindParam(':commentId', $commentsId, \PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function editComments($commentsId, $text) {
        $query = "UPDATE comments SET text = :content WHERE id = :commentId";
        $stmt =  $this->db->getDb()->prepare($query);
        $stmt->bindParam(':commentId', $commentsId, \PDO::PARAM_INT);
        $stmt->bindParam(':content', $text, \PDO::PARAM_STR);
        return $stmt->execute();
    }
}