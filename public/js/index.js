let posts = document.querySelectorAll(".slideshow .post"),
    events = document.getElementsByClassName("box-event"),
    slideTo = 1;

for (let i = 0; i < events.length; i++) countDown(i);

if (posts.length > 1) {
    setInterval(function () {
        moveSlideShow(posts.length);
    }, 5000); // 5000
}

function countDown(classNumber) {
    let html = document.getElementsByClassName("box-event")[classNumber],
        a = html.getElementsByTagName("a")[0],
        time = html.querySelector(".countdown"),
        link = time.getAttribute("title"),
        countDownDate = time.innerHTML;

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
    let now = new Date().getTime(),
        distance = (dateToSet * 1000) - now;

    let days = Math.floor(distance / (1000 * 60 * 60 * 24)),
        hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
        minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
        seconds = Math.floor((distance % (1000 * 60)) / 1000);

    if (hours.toString().length == 1) { hours = "0" + hours; }
    if (minutes.toString().length == 1) { minutes = "0" + minutes; }
    if (seconds.toString().length == 1) { seconds = "0" + seconds; }

    if (distance < 0) { return "C'est parti!"; }
    if (days > 0) { return days + " jours"; }
    return hours + ":" + minutes + ":" + seconds;
}

function moveSlideShow (time)
{
    let toMove = document.querySelector(".inMovement"),
        ctWidth = toMove.clientWidth,
        pixels = ctWidth * slideTo;
    
    if (slideTo == 1) toMove.style.right = '0px';

    if (slideTo == time) {
        posts[0].classList.add('show');
        toMove.style.right = '0px';
        slideTo = 1;
    } else {
        toMove.style.right = pixels + 'px';
        posts[0].classList.remove('show');
        slideTo++;
    }
    posts[(slideTo - 1)].classList.add('show');
    posts[slideTo].classList.remove('show');
}