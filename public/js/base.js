window.onload = loading;
let myNavbarIs = false;

const OnEvent = (doc) => {
    return {
        on: (type, selector, callback) => {
            doc.addEventListener(type, (event)=>{
                if(!event.target.matches(selector)) return;
                callback.call(event.target, event);
            }, false);
        }
    }
};

OnEvent(document).on('click', '[class*="dropdown-open-"]', function (e) {
    let target = e.target,
        className = e.target.className.split(' '),
        substring = className.filter(found => found.includes('dropdown-open-')),
        word = substring.join().split('-')[2],
        ddName = '.dropdown-' +word,
        content = document.querySelector(ddName),
        noHeightSet = target.classList.contains('open');
    
    (noHeightSet)? target.classList.remove("open") : target.classList.add("open");

    const sh = content.scrollHeight;
    content.style.height = (noHeightSet)? 0 : sh +'px';
});

OnEvent(document).on('click', '[class*="answerTo-"]', function (e) {
    let target = e.target,
        className = e.target.className.split(' '),
        substring = className.filter(found => found.includes('answerTo-')),
        idAswr = substring.join().split('-')[1],
        usernameAswr = substring.join().split('-')[2];
    
    answer(idAswr, usernameAswr);
});

OnEvent(document).on('click', '[class*="navbar-"]', function (e) {
    let className = e.target.className.split(' '),
        substring = className.filter(found => found.includes('navbar-')),
        navbar = substring.join().split('-')[1],
        toOpen = substring.join().split('-')[2];
    
    navbars(navbar, toOpen);
});

document.addEventListener("click", (evt) => {
    const boxLogin = document.getElementById("login");
    let openButton = document.getElementsByClassName("login")[0];
    let targetEl = evt.target; // clicked element
    
    if (boxLogin) {
        do {
            if(targetEl == boxLogin || targetEl == openButton) { return; }
            // Go up the DOM
            targetEl = targetEl.parentNode;
        } while (targetEl);
        // This is a click outside.      
        loginPop(false);
    }
});


function answer(id, username)
{
    let container = document.querySelector("form"),
        answerTo = document.querySelector("form input[type='hidden']");
    
    answerTo.value = id;

    if (document.querySelector("form .endAnswerTo") === null) {
        container.prepend(generateAnswerBtn(username));
    } else {
        document.querySelector("form .endAnswerTo").innerHTML = generateAnswerBtn(username, true);
    }
}

function endAnswer()
{
    let answerTo = document.querySelector("form input[type='hidden']"),
        p = document.querySelector("form .endAnswerTo");

    answerTo.value = 0;
    p.remove();
}

function generateAnswerBtn (username, appended = false)
{
    let btnCancel = document.createElement("div");
        btnCancel.classList.add("button-danger");
        btnCancel.setAttribute("onclick", "endAnswer()");
        btnCancel.innerHTML = "X";
    
    let text = document.createElement("p");
        text.innerHTML = "En réponse à " +username;

    let box = document.createElement("div");
        box.classList.add("endAnswerTo");
    
    let html = btnCancel.outerHTML + text.outerHTML;

    box.innerHTML = html;

    return (appended) ? html : box;
}

function loading ()
{
    loader = document.getElementById("loading");
    loader.classList.remove("loading");
    loader.classList.add("loaded");

    setTimeout(function(){ loader.style.display = "none"; }, 400);
}

function navbars (nav, section)
{
    let navbar = '.nav-' +nav,
        sectionsBox = document.querySelector( navbar+ ' .sections'),
        allSections = sectionsBox.querySelectorAll('li'),
        optionsBox = document.querySelector( navbar+ ' .options'),
        allOptions = optionsBox.querySelectorAll('ul');
    
    for (let i=0; i<allSections.length; i++) {
        let openSection = allSections[i].className.split('-')[1].split(' ')[0];

        if (openSection !== section) {
            allSections[i].classList.remove("open");
            allOptions[i].classList.remove("open");
        } else {
            allSections[i].classList.add("open");
            allOptions[i].classList.add("open");
        }
    }
}

function myNavbar ()
{
    let box = document.getElementById("myNavbar");

    if (myNavbarIs) {
        myNavbarIs = false;
        box.classList.remove("open");
    } else {
        myNavbarIs = true;
        box.classList.add("open");
    }
}

function loginPop (state)
{
    let box = document.getElementById("login");
    let button = document.getElementsByClassName("login")[0];

    if(state) {
        box.classList.add('open');
        button.setAttribute('onclick',"loginPop(false)");
    } else {
        box.classList.remove('open');
        button.setAttribute('onclick',"loginPop(true)");
    }
}