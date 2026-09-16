document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('authModal');
    const openBtn = document.getElementById('openAuthFromMini');
    const closeBtn = document.getElementById('closeAuthModal'); 
    
    // Элементы управления
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const form = document.getElementById('authForm');
    const submitBtn = document.getElementById('authSubmitBtn');
    const actionInput = document.getElementById('formAction');
    const regFields = document.getElementById('regFields');

    /* ========= ПЕРЕКЛЮЧЕНИЕ РЕЖИМОВ (ВКЛАДКИ) ========= */
    if (loginTab && registerTab && form) {
        
        // Переключение на "Регистрацию"
        registerTab.addEventListener('click', function(e) {
            e.preventDefault();
            
            loginTab.classList.remove('active');
            registerTab.classList.add('active');
            
            regFields.style.display = 'block'; // Показываем доп. поля
            actionInput.value = 'register';
            submitBtn.textContent = 'Зарегистрироваться';
        });

        // Переключение на "Вход"
        loginTab.addEventListener('click', function(e) {
            e.preventDefault();
            
            registerTab.classList.remove('active');
            loginTab.classList.add('active');
            
            regFields.style.display = 'none'; // Скрываем доп. поля
            actionInput.value = 'login';
            submitBtn.textContent = 'Войти';
        });
    }

    /* === ОТКРЫТИЕ / ЗАКРЫТИЕ ОКНА === */
    if (openBtn && modal) {
        openBtn.onclick = function(e) { e.preventDefault(); modal.style.display = 'block'; };
    }
    if (closeBtn && modal) {
        closeBtn.onclick = function(e) { 
            e.stopPropagation(); 
            modal.style.display = 'none'; 
        };
    }
    window.onclick = function(event) { if (event.target == modal) modal.style.display = 'none'; };

    /* ========= ОБРАБОТКА ФОРМЫ (AJAX) === */
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            fetch('auth.php', {          
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Успешно! Добро пожаловать.");
                    location.reload(); 
                } else {
                    alert(data.message || "Ошибка сети");
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Сервер недоступен.');
            });
        }); 
    }
});