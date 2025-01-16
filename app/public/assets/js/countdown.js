function startCountdown(dateFin) {
    const dateFinStage = new Date(dateFin).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = dateFinStage - now;

        if (distance <= 0) {
            document.getElementById('countdown').innerText = "Stage terminé";
            document.getElementById('countdown').classList.add('text-red-600');
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const countdownElement = document.getElementById('countdown');
        countdownElement.innerText = `${days} jours, ${hours} heures, ${minutes} minutes, ${seconds} secondes`;

        if (days > 30) {
            countdownElement.className = 'text-green-600';
        } else if (days > 10) {
            countdownElement.className = 'text-orange-600';
        } else {
            countdownElement.className = 'text-red-600';
        }
    }

    setInterval(updateCountdown, 1000);
}
