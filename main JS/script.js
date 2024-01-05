// document.addEventListener("DOMContentLoaded", function () {
//             var vitaemoElement = document.querySelector(".vitaemo");
//             var text = "Вітаємо, <?php echo $_SESSION['user_name']; ?>!";
//             var index = 0;

//             function type() {
//                 vitaemoElement.innerHTML = text.slice(0, index++);

//                 if (index <= text.length) {
//                     setTimeout(function () {
//                         type();
//                     }, 100);
//                 }
//             }

//             type();
// });
        
document.addEventListener("DOMContentLoaded", function () {
            var vitaemoElement = document.querySelector(".vitaemo");
            var someVariable = "<?php echo $_SESSION['user_name']; ?>";
            var text = "Вітаємо, "+someVariable+"!";
            var index = 0;

            function type() {
                vitaemoElement.innerHTML = text.slice(0, index++);

                if (index <= text.length) {
                    setTimeout(function () {
                        type();
                    }, 100);
                }
            }

            type();
            
        });