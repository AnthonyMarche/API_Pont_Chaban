// get countdown div and next closure data
const countdown = document.getElementById('countdown');
const nextClosure = document.getElementById('nextClosure').innerHTML;

// reformat date data
const startDate = new Date();
const endDate = new Date(nextClosure);

// get difference in seconds from these date
const diffInMilliseconds = endDate.getTime() - startDate.getTime();
let diffInSeconds = diffInMilliseconds / 1000;

// Transform diffInSeconds value to days, hours, minutes and seconds
function updateCountdown() {
    const days = Math.floor(diffInSeconds / 86400);
    const hours = Math.floor((diffInSeconds % 86400) / 3600);
    const minutes = Math.floor(((diffInSeconds % 86400) % 3600) / 60);
    const seconds = Math.floor((diffInSeconds % 86400) % 3600) % 60;

    // Write result in view
    countdown.innerHTML = days + "J " + hours + "h " + minutes + "min " + seconds + "sec";

    // Reduce seconds by 1
    diffInSeconds--;

    // If the number of seconds is 0 clear and new text in view
    if (diffInSeconds < 0) {
        clearInterval(countdownInterval);
        countdown.innerHTML = "La circulation maintenant fermée !";
    }
}

// set interval to call updateCountdown every seconds
const countdownInterval = setInterval(updateCountdown, 1000);

// return the current date and time
function updateClock() {
    const today = new Date();
    document.getElementById('today').innerHTML = today.toLocaleDateString();
}

// refresh today every second
setInterval(updateClock, 1000);