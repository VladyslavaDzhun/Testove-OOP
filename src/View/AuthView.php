<?php
namespace Vladyslava\TestoveOop\View;

class AuthView
{
    public function renderLoginForm($message = '')
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Вхід</title>
  <link href="../../static/css/app.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="form-container">
      <div class="wrapper wrapper--lg">
        <h1 class="form-title">Вхід</h1>

        <?php echo $message; ?>
        <div class="shadow-lg p-4 rounded">
          <form method="post" action="index.php?action=login">
            <div class="form-item">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-item">
              <label class="form-label">Пароль</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-2">Увійти</button>
          </form>
        </div>
        <div class="mt-4">
          <span>Не маєте акаунта?</span>
          <a href="index.php?action=register" class="link-secondary link-offset-2">Зареєструйтесь</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<?php
}

    public function renderRegistationForm($message = '')
    {
        ?>
<!DOCTYPE html>
<html>

<head>
  <title>Реєстрація</title>
  <link rel="stylesheet" href="../../static/css/app.css">
</head>

<body>
  <div class="container">
    <div class="wrapper wrapper--lg">
      <h1 class="form-title">Реєстрація</h1>
  
      <?php echo $message; ?>
      <div class="shadow-lg p-4 rounded">
        <form method="post" action="index.php?action=register">
          <div class="form-item">
            <label class="form-label">Ім'я:</label>
            <input type="text" name="name" class="form-control" required>
          </div>
  
          <div class="form-item">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
          </div>
  
          <div class="form-item">
            <label class="form-label">Пароль:</label>
            <input type="password" name="password" class="form-control" required>
          </div>
  
          <button type="submit" class="btn btn-success w-100 mt-2">Зареєструватися</button>
        </form>
      </div>
      <div class="mt-4">
        <span>Вже маєте акаунт?</span>
        <a href="index.php?action=login" class="link-secondary link-offset-2 ">Увійдіть</a>
      </div>
    </div>
  </div>
</body>

</html>

<?php
}
}