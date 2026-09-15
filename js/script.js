/* === АВТОРИЗАЦИЯ ИЗ МИНИ-ПАНЕЛИ (в шапке) === */
if (miniLoginForm) {
    miniLoginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(miniLoginForm);
        
        fetch('auth.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'cabinet.html';
            } else {
                alert(data.message); 
            }
        });
    }); // <-- Добавили эту строку
}