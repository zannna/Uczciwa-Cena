const search = document.querySelector('input[name="search-place"]');
loadButtons();
const adContainer = document.querySelector(".things");
search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        const data = {search: this.value};
        fetch("/getAdvertisementByPlace", {
            method: "POST", headers: {
                'Content-Type': 'application/json'
            }, body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (projects) {
            adContainer.innerHTML = "";
            loadProjects(projects);
            loadButtons();

        });
    }

});
previous = '';

function loadProjects(projects) {
    clone = null;
    liked = Object.values(projects[2]);
    for (i = 0; i < projects[0].length; i++) {
         display = false;
        if (projects[0][i] != null) {
            if (liked.includes(projects[0][i].id)) {
                display = true;
            }
            if (projects[projects.length - 1] == true) {
                clone = createProject(projects[0][i], display, true);
                createAdminComment(projects[1][i], projects[0][i].id);
            } else {
                clone = createProject(projects[0][i], display, false);
                createComment(projects[1][i], projects[0][i].id);
            }


        }
    }
    loadButtons();


}

function createComment(comment, id) {
    element = document.getElementById(id);
    for (const value of comment) {
        div = document.createElement('div');
        div.classList.add('comments');
        content = document.createTextNode(value.content);
        div.appendChild(content);
        element.querySelector('.comments-section').appendChild(div);
    }
}

function createAdminComment(comment, id) {
    element = document.getElementById(id);
    for (const value of comment) {
        const template = document.querySelector("#admin-comments-template")
        const clone = template.content.cloneNode(true);
        const button = clone.querySelector(".deleteCommentButton");
        button.value = value.comment_id;
        const div = clone.querySelector(".comments");
        div.innerHTML = value.content;
        commentSection = element.querySelector(".comments-section");
        commentSection.appendChild(clone);
    }
    deleteCommentButtons = document.querySelectorAll(".deleteCommentButton");
    deleteCommentButtons.forEach(button => button.addEventListener("click", deleteInappropriateComment));
}

function deleteInappropriateAdvertisement() {
    const clicked = this;
    const container = clicked.parentElement;
    const id = container.getAttribute("id");
    fetch(`/deleteAdvertisementAdmin/${id}`).then(function () {
        const element = document.getElementById(id);
        element.remove();
    });
}

function deleteInappropriateComment() {
    const clicked = this;
    id = clicked.value;
    fetch(`/deleteComment/${id}`).then(function () {
        clicked.parentNode.parentNode.removeChild(clicked.parentNode);
    });
}


function createProject(project, display = false, admin = false) {
    const template = document.querySelector("#advertisement-template")
    const clone = template.content.cloneNode(true);
    if (admin == true) {
        clone.querySelector(".deleteButton").style.visibility = 'visible';
        clone.querySelector(".deleteDescription").style.visibility = 'visible';
        deleteCommentButtons = clone.querySelectorAll(".deleteButton");
        deleteCommentButtons.forEach(button => button.addEventListener("click", deleteInappropriateAdvertisement));
    }

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
    if (display == true) {
        const heart = clone.querySelector(".heartButton");
        heart.style.backgroundImage = "url(\"/public/img/ikonki/red_heart.png\")";

    }
    adContainer.appendChild(clone);

}

const elm = document.querySelector('.things');
document.addEventListener('DOMContentLoaded', function () {


    if (elm.id != "object") elm.addEventListener('scroll', callFuntion);
    ok = 0;
    value = 2;

    function callFuntion() {

        scrollHeight = elm.scrollHeight;
        scrollTop = elm.scrollTop;
        clientHeight = elm.clientHeight;
        sth = {offset: value};
        if (scrollHeight - scrollTop - 600 <= clientHeight) {
            if (ok == 0) {
                ok = 1;
                fetch(`/indexWithAdvertisements`, {
                    method: "POST", headers: {
                        'Content-Type': 'application/json'
                    }, body: JSON.stringify(sth)
                }).then(function (response) {
                    return response.json();
                }).then(function (projects) {
                    loadProjects(projects);
                    ok = 0;
                });
                value += 2;
                sth = {offset: value};

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
    const dataToSend = {content: comment, idAd: id};
    fetch("/sendComment", {
        method: "POST", headers: {
            'Content-Type': 'application/json'
        }, body: JSON.stringify(dataToSend)
    }).then(function () {
        container.querySelector(".commentToSend").value = "";
        div = document.createElement('div');
        div.classList.add('comments');
        content = document.createTextNode(comment);
        div.appendChild(content);
        container.querySelector('.comments-section').appendChild(div);
    }).catch((error) => {
        div = document.createElement('div');
        div.classList.add('message');
        content = document.createTextNode("Zaloguj się, aby dodać komentarz");
        div.appendChild(content);
        container.querySelector(".message").appendChild(div);


    });


}

function displayNumber() {
    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    const data = {search: id};
    phone = 0;
    fetch("/getPhoneNumber", {
        method: "POST", headers: {
            'Content-Type': 'application/json'
        }, body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (number) {
        phone = number;
        div = document.createElement('div');
        div.classList.add('popup');
        content = document.createTextNode(" numer telefonu: " + phone);
        div.appendChild(content);
        container.querySelector('.popup-section').appendChild(div);
        container.querySelector(".popup").style.display = 'block';

    }).catch((error) => {
        createMessage(container, "Zaloguj się, aby zobaczyć");
    });


}

function createMessage(container, message) {
    div = document.createElement('div');
    div.classList.add('popup');
    content = document.createTextNode(message);
    div.appendChild(content);
    container.querySelector('.popup-section').innerHTML = "";
    container.querySelector('.popup-section').appendChild(div);
    container.querySelector(".popup").style.display = 'block';
}

function like() {
    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    value = null;
    if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/red_heart.png\")" || clicked.className == "redHeartButton") {
        value = "unlike";
    } else if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/heart.png\")" || clicked.style.backgroundImage == "") {
        value = "like";
    }

    const info = {liked: id, option: value};
    fetch("/like", {
        method: "POST", headers: {
            'Content-Type': 'application/json'
        }, body: JSON.stringify(info)
    }).then(function () {
        if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/red_heart.png\")" || clicked.className == "redHeartButton") {
            clicked.style.backgroundImage = "url('/public/img/ikonki/heart.png')";
        } else if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/heart.png\")" || clicked.style.backgroundImage == "") {
            clicked.style.backgroundImage = "url('/public/img/ikonki/red_heart.png')";
        }
    }).catch((error) => {
        createMessage(container, "Zaloguj się, aby polubić");
    });


}

function loadButtons() {
    phoneButtons = document.querySelectorAll(".phoneButton");
    sendButtons = document.querySelectorAll(".sendButton");
    heartButtons = document.querySelectorAll(".heartButton");
    redHeartButtons = document.querySelectorAll(".redHeartButton");
    sendButtons.forEach(button => button.addEventListener("click", send));
    phoneButtons.forEach(button => button.addEventListener("click", displayNumber));
    heartButtons.forEach(button => button.addEventListener("click", like));
    redHeartButtons.forEach(button => button.addEventListener("click", like));
}

deleteButtons = document.querySelectorAll(".deleteButton");
deleteButtons.forEach(button => button.addEventListener("click", deleteInappropriateAdvertisement));
deleteCommentButtons = document.querySelectorAll(".deleteCommentButton");
deleteCommentButtons.forEach(button => button.addEventListener("click", deleteInappropriateComment));