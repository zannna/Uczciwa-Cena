const search = document.querySelector('input[placeholder="miasto, województwo"]');
loadButtons();
const adContainer = document.querySelector(".things");
search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const data = {search: this.value};

        fetch("/getAdvertisementByPlace", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (projects) {
            adContainer.innerHTML = "";
            loadProjects(projects);
            loadButtons();
        });
    }

});
let previous = '';

function loadProjects(projects) {
    let clone = null;
    var liked = Object.values(projects[2]);
    for (var i = 0; i < projects.length; i++) {
        var display=false;
        if (projects[0][i] != null) {
            if(liked.includes(projects[0][i].id))
            {
                display=true;
            }
            clone = createProject(projects[0][i], display);
            console.log(projects[0][i]);
            console.log(projects[1][i]);
            createComment(projects[1][i], projects[0][i].id);


        }
    }
    loadButtons();


}

function createComment(comment, id) {
    element = document.getElementById(id);
    for (const value of comment) {
        let div = document.createElement('div');
        div.classList.add('comments');
        let content = document.createTextNode(value.content);
        div.appendChild(content);
        element.querySelector('.comments-section').appendChild(div);
    }
}

function createProject(project, display=false) {
    const template = document.querySelector("#advertisement-template")
    const clone = template.content.cloneNode(true);
    // const div = clone.querySelector("div");
    // div.id = project.id;
    const div = clone.querySelector("div");
    div.id = project.id;
    const name = clone.querySelector("p1");
    name.innerHTML = project.name;
    const image = clone.querySelector("img");
    image.src = `/public/uploads/${project.picture1}`;
    const place = clone.querySelector("p2");
    place.innerHTML = project.place;
    const description = clone.querySelector("p3");
    description.innerHTML = project.description;
    const object = clone.querySelector("p1");
    object.innerHTML = project.name;
    if(display==true)
    {
        const heart = clone.querySelector(".heartButton");
        heart.style.backgroundImage = "url(\"/public/img/ikonki/red_heart.png\")";

    }
    console.log(object.adName);
    adContainer.appendChild(clone);

}

document.addEventListener('DOMContentLoaded', function () {
    const elm = document.querySelector('.things');


    if (elm.id != "object")
        elm.addEventListener('scroll', callFuntion);
    var ok = 0;
    var value = 2;

    function callFuntion() {

        var scrollHeight = elm.scrollHeight;
        var scrollTop = elm.scrollTop;
        var clientHeight = elm.clientHeight;
        var sth = {offset: value};
        //console.log(scrollHeight+" "+scrollTop+" "+clientHeight);
        if (scrollHeight - scrollTop - 600 <= clientHeight) {
            if (ok == 0) {
                ok = 1;
                fetch(`/indexWithAdvertisements`, {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(sth)
                }).then(function (response) {
                    console.log(response);
                    return response.json();
                }).then(function (projects) {
                    console.log("auuuu");
                    console.log(projects);
                    loadProjects(projects);

                    ok = 0;
                });
                value += 2;
                sth = {offset: value};
                // console.log(value);
            }
        }


    }
});

const sendButtons = document.querySelectorAll(".sendButton")

function send() {
    const clicked = this;
    const container = clicked.parentElement.parentElement;
    const id = container.getAttribute("id");
    const comment = container.querySelector(".commentToSend").value;
    console.log(comment);
    const dataToSend = {content: comment, idAd: id};
    fetch("/sendComment", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dataToSend)
    });
    let div = document.createElement('div');
    div.classList.add('comments');
    let content = document.createTextNode(comment);
    div.appendChild(content);
    container.querySelector('.comments-section').appendChild(div);

    // const adContainer = document.querySelector(".comments");
    //  adContainer.style.height="3.5vh";


}

function displayNumber() {
    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    const data = {search: id};
    var phone = 0;
    console.log(id);
    fetch("/getPhoneNumber", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        console.log(response);
        return response.json();
    }).then(function (number) {
        console.log(number);
        phone = number;
        console.log(phone);
        let div = document.createElement('div');
        div.classList.add('popup');
        let content = document.createTextNode(" numer telefonu: " + phone);
        div.appendChild(content);
        container.querySelector('.popup-section').appendChild(div);
        container.querySelector(".popup").style.display = 'block';

    });


}

function like() {
    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    console.log("auuuu");
    console.log(clicked.style.backgroundImage);
    let value = null;
    if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/red_heart.png\")" || clicked.className == "redHeartButton") {
        console.log("nieee");
        clicked.style.backgroundImage = "url('/public/img/ikonki/heart.png')";
        value = "unlike";
    } else if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/heart.png\")" || clicked.style.backgroundImage == "") {
        console.log("auuuu");
        clicked.style.backgroundImage = "url('/public/img/ikonki/red_heart.png')";
        value = "like";
    }


    const info = {liked: id, option: value};
    fetch("/like", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(info)
    });


}

function loadButtons() {
    let phoneButtons = document.querySelectorAll(".phoneButton");
    let sendButtons = document.querySelectorAll(".sendButton");
    let heartButtons = document.querySelectorAll(".heartButton");
    let redHeartButtons = document.querySelectorAll(".redHeartButton");
    sendButtons.forEach(button => button.addEventListener("click", send));
    phoneButtons.forEach(button => button.addEventListener("click", displayNumber));
    heartButtons.forEach(button => button.addEventListener("click", like));
    redHeartButtons.forEach(button => button.addEventListener("click", like));
}

/*
phoneButton.onmouseout = function() {
    document.querySelector(".popup").style.display = 'none';
}
*/


/*
var spSsd = document.getElementById("phoneWindow");
spSsd.addEventListener("mouseover", function () {
    this.style.width = "240px";
    this.setAttribute("title", "(0/0) mqe");
});
*/
