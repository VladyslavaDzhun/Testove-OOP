<?php
namespace Vladyslava\TestoveOop\View;

class NewsView
{
    public function renderNews($newsList = [])
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Головна сторінка</title>
  <link rel="stylesheet" href="../../static/css/app.css">
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
      <h1 class="header">Головна сторінка</h1>
      <?php if (isset($_SESSION['user_id'])) {?>
      <p class="vitaemo">Вітаємо,
        <?php echo $_SESSION['user_name']; ?>!
      </p>
      <div class="text-center my-2">
        <a href="index.php?action=create_news" class="btn btn-dark">Створити нову новину</a>
        <div class=mt-2>
          <a href="index.php?action=logout" class="btn btn-light">Вийти</a>
        </div>
      </div>
      <?php } else {?>
      <div class="text-center">
        <a href="index.php?action=login" class="btn btn-info mx-1">Увійти</a>
        <a href="index.php?action=register" class="btn btn-success mx-1">Зареєструватися</a>
      </div>
      <?php }?>
      <h2 class="title-news">Новини</h2>

      <?php
if (!empty($newsList)) {
            foreach ($newsList as $news) {
                echo '<div class="card mb-4">';
                echo '<div class="card-body">';
                echo '<h3 class = "card-title"> <a class="link-info" href="index.php?action=get_news&id=' . $news["id"] . '">' . htmlentities($news['title'], ENT_QUOTES) . '</a></h3>';
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

    public function renderCreateForm($message = '')
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Створення новини</title>
  <link rel="stylesheet" href="../../static/css/app.css">
</head>

<body>
  <div class="container">
    <div class="wrapper wrapper--lg">

      <h1 class="title title-md">Створення новини</h1>
      <?php echo $message; ?>
      <div class="form-wrapper">
        <form method="post" action="index.php?action=create_news">
          <div class="form-item">
            <label class="form-label">Заголовок</label>
            <input class="form-control" type="text" name="title" required>
          </div>

          <div class="form-item">
            <label class="form-label">Текст</label>
            <textarea class="form-control" name="text" rows="4" required></textarea>
          </div>

          <div class="form-footer">
            <button type="submit" class="btn btn-primary">Створити новину</button>
            <p><a href="index.php?action=home" class="return-button">На головну</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>

<?php

    }

    public function renderSingleNews($news, $userModel)
    {
        echo '<div class="page">';
        echo '<div class="container">';

        echo '<h3>' . htmlentities($news['title'], ENT_QUOTES) . '</h3>';
        echo '<p>' . htmlentities($news['text'], ENT_QUOTES) . '</p>';
        echo '<p>Автор: ' . $news['author'] . '</p>';
        if ($userModel->isUserLoggedIn() && $userModel->isAuthor($_SESSION['user_id'], $news['author_id'])) {
            echo '<form method="post" action="index.php?action=delete_news">';
            echo '<a href="index.php?action=edit_news&news_id=' . $news['id'] . '" class = "btn btn-info">Редагувати новину</a>';
            echo '<form method="post" action="index.php?action=delete_news">';
            echo '<input type="hidden" name="id" value=' . $news['id'] . ' required>';
            echo '<button type="submit" class="btn btn-danger mx-1">Видалити новину</button>';

            echo '</form>';
            echo '</div>';
            echo '</div>';

        }

    }

    public function renderEditNews($news, $newsId, $message = '')
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Редагування новини</title>
  <link rel="stylesheet" href="../../static/css/app.css">
</head>

<body>
  <div class="page">
    <div class="container">
      <h1 class="title title-md">Редагування новини</h1>

      <?php echo $message; ?>
      <div class="create-news-container">
        <form method="post" action="index.php?action=edit_news&news_id=<?php echo $newsId; ?>">
          <div class="form-item">
            <label class="form-label">Заголовок</label>
            <input class="form-control" type="text" name="title" value="<?php echo $news['title']; ?>" required>
          </div>

          <div class="form-item">
            <label class="form-label">Текст</label>
            <textarea name="text" rows="4" required><?php echo $news['text']; ?></textarea>
          </div>

          <div class="form-footer">
            <button type="submit" class="btn btn-primary">Зберегти зміни</button>
            <a href="index.php?action=home" class="btn btn-link">На головну</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>

<?php
}

    public function renderComments($commentList, $userModel, $message = '')
    {

        ?>
<h2 class="title title-md mb-4">Коментарі</h2>
<?php
if (!empty($commentList)) {
            foreach ($commentList as $comment) {
                if ($userModel->isUserLoggedIn() && $userModel->isAuthor($_SESSION['user_id'], $comment['author_id'])) {
                    echo '<div class="card mb-4">';
                    echo '<div class="card-body">';

                }
                echo '<p>' . htmlentities($comment['text'], ENT_QUOTES) . '</p>';
                echo '<p>Автор: ' . $comment['author'] . '</p>';
                echo '<a href="index.php?action=edit_comment&comment_id=' . $comment['id'] . '" class ="btn btn-light">
                  Редагувати коментар
                  </a>';

                echo '<button type="submit" class = "btn btn-danger mx-1">Видалити коментар</button>';

                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class = "no-comment">Немає коментарів.</p>';
        }
        ?>
<?php
}

    public function createComments($news_id, $message = '')
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Створення коментаря</title>
  <link rel="stylesheet" href="../../static/css/app.css">
</head>

<body>
  <div class="page">
    <div class="container">
      <div class="my-5">
        <h1 class="title title-md">Створення коментаря</h1>
        <?php echo $message; ?>
        <div class="form-wrapper">
          <form method="post" action="index.php?action=create_comment&news_id=<?php echo $news_id; ?>">
            <div class="form-item">
              <label class="form-label">Текст коментаря:</label>
              <textarea class="form-control" name="text" rows="4" required></textarea>
            </div>

            <div class="form-footer">
              <button type="submit" class="btn btn-primary">Залишити коментар</button>
              <a href="index.php?action=home" class="btn btn-link">На головну</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<?php
}

    public function updateComments($commentsId, $comment, $message)
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Редагування коментаря</title>
  <link rel="stylesheet" href="../../static/css/app.css">
</head>

<body>
  <div class="container">
    <h1 class="edit_comment_news">Редагування коментаря</h1>

    <?php echo $message; ?>
    <div class="create-news-container">
      <form method="post" action="index.php?action=edit_comment&comment_id=<?php echo $commentsId; ?>">
        <label class="text_edit_comment_news">Текст коментаря:</label>
        <textarea name="text" rows="4" required><?php echo $comment['text']; ?></textarea>

        <button type="submit" class="button_edit_comment_news">Зберегти зміни</button>
      </form>

      <p><a href="index.php?action=home" class="return-button">На головну</a></p>
    </div>
  </div>
</body>

</html>

<?php
}
}