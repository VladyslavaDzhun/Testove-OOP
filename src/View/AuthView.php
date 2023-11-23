<?php
namespace Vladyslava\TestoveOop\View;

class AuthView {
    public function renderLoginForm($message = '') {
        ?>
                <!DOCTYPE html>
        <html>
        <head>
            <title>Вхід</title>
            <link href="/static/css/style.css"  rel="stylesheet">
            
        </head>
        <body>
            <div class="form-container">
                <h1 class = "form-title">Вхід</h1>
                
                <?php echo $message; ?>
                <div class="login">
                    <form method="post" action="index.php?action=login">
                        <label>Email:</label>
                        <input type="email" name="email" class="login-input" required><br>
                        
                        <label>Пароль:</label>
                        <input type="password" name="password" class="password-input" required><br>
                        
                        <button type="submit" class="submit-button">Увійти</button>
                    </form>
                </div>
                <p>Не маєте акаунта? <a href="index.php?action=register" class="register-link">Зареєструйтесь</a></p>
            </div>    
        </body>
        </html>
            <?php
    }

    public function renderRegistationForm($message = '') {
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Реєстрація</title>
            <link rel="stylesheet" href="/static/css/style.css">
        </head>
        <body>
            <div class="form-container">
                <h1 class = "form-title">Реєстрація</h1>
            
            <?php echo $message; ?>
                <div class="register">
                    <form method="post" action="index.php?action=register">
                        <label>Ім'я:</label>
                        <input type="text" name="name" class = "name-input" required><br>
                
                        <label>Email:</label>
                        <input type="email" name="email" class = "login-input" required><br>
                
                        <label>Пароль:</label>
                        <input type="password" name="password" class = "password-input" required><br>
                
                    <button type="submit" class = "submit-button">Зареєструватися</button>
                    </form>
                </div>
            <p>Вже маєте акаунт? <a href="index.php?action=login" class = "register-link">Увійдіть</a></p>
            </div>
        </body>
        </html>

        <?php
    }
}

