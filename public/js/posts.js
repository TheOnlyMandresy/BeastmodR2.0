function pagination(id, page) {
    var contenair = document.getElementById("comments");
    var head = document.getElementsByTagName("head")[0];
    var linkPost = "/posts/" + id;
    var linkComments = "/posts/comments/" + id + "/" + page;
    var xhttp = new XMLHttpRequest();

    console.log(head);

    xhttp.open("POST", linkPost, true); 
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            contenair.innerHTML = '<object type="text/html" data="' + linkComments + '"></object>';
            setTimeout(function(){
                test = contenair.querySelector("#test").innerHTML;
                console.log(test);
                contenair.innerHTML = test;
            }, 1000);
        }
    };
    var data = {page : page};
    xhttp.send(JSON.stringify(data));
}
