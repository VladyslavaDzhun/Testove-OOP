<?php
namespace Vladyslava\TestoveOop\View;
class NewsView {
    public function renderNews($newsList = []) {
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Головна сторінка</title>
            <link rel="stylesheet" href="/static/css/style.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
            
        </head>
        <body>
            <div class="page">
                <div class="container">
                    <h1 class = "header">Головна сторінка</h1>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <p class = "vitaemo">Вітаємо, <?php echo $_SESSION['user_name']; ?>!</p>
                        <a href="index.php?action=create_news" class = "news-button">Створити нову новину</a>
                        <a href="index.php?action=logout" class = "logout-buttom">Вийти</a>
                    <?php } else { ?>
                        <div class="register-buttons">
                            <a href="index.php?action=login" class = "login-button">Увійти</a>
                            <a href="index.php?action=register" class = "register-button">Зареєструватися</a>
                        </div>
                    <?php } ?>
                    <h2 class = "title-news">Новини</h2>
                
                    <?php
                    if (!empty($newsList)) {
                        foreach ($newsList as $news) {
                            echo '<div>';
                            echo '<div class="news-container">';
                            echo '<h3 class = "title-news-home"> <a href="index.php?action=get_news&id='.$news["id"].'">' . htmlentities( $news['title'], ENT_QUOTES) .'</a></h3>';
                            echo '<p class = "text-news-home">' . htmlentities($news['text'], ENT_QUOTES) . '</p>';
                            echo '<p class = "author-home">Автор: ' . htmlentities($news['author'], ENT_QUOTES) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class = "no-news-home">Немає новин.</p>';
                        }
                    ?>
                </div>
            </div>     
        </body>
        </html>
        <?php
    }

    public function renderCreateForm($message = '') {
    ?>
                <!DOCTYPE html>
        <html>
        <head>
            <title>Створення новини</title>
            <link rel="stylesheet" href="/static/css/app.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        </head>
        <body>
            <div class="container">
                <div class="wrapper wrapper--lg">

                    <h1  class = "title title-md">Створення новини</h1>
                    <?php echo $message; ?>
                    <div class="form-wrapper">
                        <form method="post" action="index.php?action=create_news">
                            <label class = "form-item__label">Заголовок:</label>
                            <input class = "form-item__field" type="text" name="title" required><br>

                            <div class="form-item">
                            <label class = "form-item__label">Текст:</label>
                            <textarea name="text" rows="4" required></textarea><br>
                            </div>
                        
                            <div class="form-footer">
                                <button type="submit" class = "btn btn-primary">Створити новину</button>
                                <p><a href="index.php?action=home" class = "return-button">На головну</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>

    <?php
            
    }

    public function renderSingleNews($news, $userModel) {
        echo '<link href="/static/css/app.css"  rel="stylesheet">';
        echo '<div class="page">';
        echo '<div class="container">';
        if ($userModel->isUserLoggedIn() && $userModel->isAuthor($_SESSION['user_id'], $news['author_id'])){
        echo '<div class="button-container">';
        echo '<a href="index.php?action=edit_news&news_id='.$news['id'].'" class = "edit-news-button">Редагувати новину</a>';
        echo '<form method="post" action="index.php?action=delete_news">';
        echo '<input type="hidden" name="id" value='.$news['id'].' required><br>';
        echo '<button type="submit" class = "delete-news-button">Видалити новину</button>';
        echo '</form>';
        echo '<div>';
        }
        echo '<div>';
        echo '<h3>' . htmlentities($news['title'], ENT_QUOTES) . '</h3>';
        echo '<p>' . htmlentities($news['text'], ENT_QUOTES) . '</p>';
        echo '<p>Автор: ' . $news['author'] . '</p>';
        echo '</div>';
    }

    public function renderEditNews($news, $newsId, $message = '') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Редагування новини</title>
            <link rel="stylesheet" href="/static/css/app.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        </head>
        <body>
            <div class="container">
                <h1 class = "title title-md">Редагування новини</h1>
                
                <?php echo $message; ?>
                <div class="create-news-container">
                    <form method="post" action="index.php?action=edit_news&news_id=<?php echo $newsId; ?>">
                        <div class="form-item">
                            <label class = "form-item__label">Заголовок:</label>
                            <input class="form-item__field" type="text" name="title" value="<?php echo $news['title']; ?>" required><br>
                        </div>

                        <div class="form-item">
                            <label class = "form-item__label">Текст:</label>
                            <textarea name="text" rows="4" required><?php echo $news['text']; ?></textarea><br>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class = "btn btn-primary">Зберегти зміни</button>
                            <p><a href="index.php?action=home" class = "return-button">На головну</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </body>
        </html>

                <?php
    }

    public function renderComments($commentList,$userModel, $message = '') {
        ?>
        <h2 class = "title title-md">Коментарі</h2>
        <?php
        if (!empty($commentList)) {
            foreach ($commentList as $comment) {
                echo '<div>';
                if ($userModel->isUserLoggedIn() && $userModel->isAuthor($_SESSION['user_id'], $comment['author_id'])){
                echo '<div class="comment-item">';
                echo '<a href="index.php?action=edit_comment&comment_id='.$comment['id'].'" class = "edit-comment-button">Редагувати коментар </a>';
                echo '<form method="post" action="index.php?action=delete_comment">';
                echo '<input type="hidden" name="id" value='.$comment['id'].' required><br>';
                echo '<button type="submit" class = "delete-comment-button">Видалити коментар</button>';
                echo '</form>';
                echo '</div>';
                }
                echo '<p>' . htmlentities($comment['text'], ENT_QUOTES) . '</p>';
                echo '<p>Автор: ' . $comment['author'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p class = "no-comment">Немає коментарів.</p>';
        }
            echo '</div>';
            echo '</div>';
        ?>
                <?php
    }

    public function createComments ($news_id, $message = '') {
        ?>
                <!DOCTYPE html>
        <html>
        <head>
            <title>Створення коментаря</title>
            <link rel="stylesheet" href="/static/css/app.css">
        </head>
        <body>
            <div class="wrapper wrapper--lg">
                <h1 class="title title-md">Створення коментаря</h1>
                <?php echo $message; ?>
                    <div class="form-wrapper">
                        <form method="post" action="index.php?action=create_comment&news_id=<?php echo $news_id; ?>">
                            <div class="form-item">
                                <label class="form-item__label">Текст коментаря:</label>
                                <textarea class="form-item__field" name="text" rows="4" required></textarea><br>
                            </div>

                            <div class="form-footer">
                                <button type="submit" class = "btn btn-primary">Залишити коментар</button>
                                <p><a href="index.php?action=home" class = "return-button">На головну</a></p>
                            </div>
                        </form>
                    </div>
            </div>
        </body>
        </html>
<?php
    }

    public function updateComments($commentsId, $comment, $message) {
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Редагування коментаря</title>
            <link rel="stylesheet" href="/static/css/app.css">
        </head>
        <body>
            <div class="container">
                <h1 class = "edit_comment_news">Редагування коментаря</h1>
                
                <?php echo $message; ?>
                <div class="create-news-container">
                    <form method="post" action="index.php?action=edit_comment&comment_id=<?php echo $commentsId; ?>">
                        <label class = "text_edit_comment_news">Текст коментаря:</label>
                        <textarea name="text" rows="4" required><?php echo $comment['text']; ?></textarea><br>
                        
                        <button type="submit" class = "button_edit_comment_news">Зберегти зміни</button>
                    </form>
                    
                    <p><a href="index.php?action=home" class = "return-button">На головну</a></p>
                </div>
            </div>
        </body>
        </html>

        <?php
    }
}

