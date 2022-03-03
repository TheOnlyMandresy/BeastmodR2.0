for (let i = 0; i < document.getElementsByClassName("box-event").length; i++) {
    countDown(i);
}

function countDown(classNumber) {
    let html = document.getElementsByClassName("box-event")[classNumber];
    let a = html.getElementsByTagName("a")[0];
    let time = html.querySelector(".countdown");
    let link = time.getAttribute("title");
    let countDownDate = time.innerHTML;

    if (Number.isInteger(+countDownDate)) {
        time.removeAttribute("title");

        let interval = setInterval(function() {
            if (getTimer(countDownDate) == "C'est parti!") {
                clearInterval(interval);
                a.classList.remove("active");
                a.href=link;
                setTimeout(function(){ time.innerHTML = "En cours"; }, 5000);
            }
            time.innerHTML = getTimer(countDownDate);
        }, 1000);
    }
}

function getTimer(dateToSet) {
    let now = new Date().getTime();
    let distance = (dateToSet * 1000) - now;

    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    if (hours.toString().length == 1) { hours = "0" + hours; }
    if (minutes.toString().length == 1) { minutes = "0" + minutes; }
    if (seconds.toString().length == 1) { seconds = "0" + seconds; }

    if (distance < 0) { return "C'est parti!"; }
    if (days > 0) { return days + " jours"; }
    return hours + ":" + minutes + ":" + seconds;
}