// get date data
const today = document.getElementById('today').innerHTML;
const nextClosure = document.getElementById('nextClosure').innerHTML;

// reformat date data
const startDate = new Date(today);
const endDate = new Date(nextClosure);

// get difference in seconds from these date
const diffInMilliseconds = endDate.getTime() - startDate.getTime();
let diffInSeconds = diffInMilliseconds / 1000;

// Verify if localStorage exist, if exist use it
if (localStorage.getItem('seconds')) {
    diffInSeconds = localStorage.getItem('seconds');
}

// Transform diffInSeconds value to days, hours, minutes and seconds
function updateCountdown() {
    const days = Math.floor(diffInSeconds / 86400);
    const hours = Math.floor((diffInSeconds % 86400) / 3600);
    const minutes = Math.floor(((diffInSeconds % 86400) % 3600) / 60);
    const seconds = ((diffInSeconds % 86400) % 3600) % 60;

    // Write result in view
    document.getElementById('countdown').innerHTML = days + "J " + hours + "h " + minutes + "min " + seconds + "sec";

    // Reduce seconds by 1
    diffInSeconds--;

    // update localStorage
    localStorage.setItem('seconds', diffInSeconds);

    // If the number of seconds is 0 clear and new text in view
    if (diffInSeconds < 0) {
        clearInterval(countdownInterval);
        document.getElementById('countdown').innerHTML = "La circulation maintenant fermée !";
        localStorage.removeItem('seconds');
    }
}

// set interval to call updateCountdown every seconds
const countdownInterval = setInterval(updateCountdown, 1000);