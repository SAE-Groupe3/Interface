document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const errorNotification = document.getElementById('errorNotification');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);

            try {
                const response = await fetch('/auth/login', {
                    method: 'POST',
                    body: formData,
                });

                // Vérifier si la réponse est JSON
                if (response.headers.get('content-type')?.includes('application/json')) {
                    const result = await response.json();

                    if (result.success) {
                        window.location.href = '/dashboard';
                    } else {
                        errorNotification.classList.remove('hidden');
                    }
                } else {
                    console.error('Réponse inattendue du serveur');
                }
            } catch (error) {
                console.error('Erreur lors de la connexion:', error);
            }
        });
    }
});
