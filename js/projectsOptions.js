var binButtons = document.querySelectorAll(".binButton");
const concreteButtons = document.querySelectorAll(".optionButton");
const rightContainer = document.getElementById("rightContainer");

function deleteAd() {
    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    fetch(`/deleteAdvertisement/${id}`).then(function () {
        const element = document.getElementById(id);
        element.remove();
    });

}

function createAdd(add, option) {

    let clone = null;
    if (option == 1) {
        const template = document.querySelector("#user-advertisement-template");
        clone = template.content.cloneNode(true);
        const image = clone.querySelector("img");
        image.src = `public/img/ikonki/add.svg`;
    }
    if (option == 2) {
        const template = document.querySelector("#liked-advertisement-template");
        clone = template.content.cloneNode(true);
        const button = clone.querySelector(".lookButton");
        button.value = add.id;
        console.log(button.value);
    }

    const div = clone.querySelector("div");
    div.id = add.id
    console.log(add.picture1);
    if (add.picture1 != "") {
        const image = clone.querySelector("img");
        image.src = `/public/uploads/${add.picture1}`;
    }
    rightContainer.appendChild(clone);

}

function loadAdds(adds, option) {

    adds.forEach(add => {
        console.log(option);
        createAdd(add, option);
    });

}

function loadForm(info) {
    const template = document.querySelector("#domek");
    clone = template.content.cloneNode(true);
    // console.log(clone.getElementsByName('place')[0]);
    if (info.name != null)
        clone.getElementById('name').placeholder = info.name;
    if (info.surname != null)
        clone.getElementById('surname').placeholder = info.surname;
    if (info.place != null)
        clone.getElementById('place').placeholder = info.place;
    if (info.email != null)
        clone.getElementById('email').placeholder = info.email;
    if (info.phone != null)
        clone.getElementById('phone').placeholder = info.phone;
    if (info.password != null)
        clone.getElementById('password').placeholder = info.password;

    rightContainer.appendChild(clone);
}

function manageButtons() {

    const clicked = this;
    concreteButtons.forEach(button => button.style.background = "#EAEAEA");
    this.style.background = "#AB9D91";
    var option = clicked.getAttribute("id");
    if (option == "option1") {
        fetch(`/getUserAdvertisements/js`).then(function (response) {
            console.log(response);
            return response.json();
        }).then(function (adds) {
            rightContainer.innerHTML = "";
            const template = document.querySelector("#user-addButton-template");
            clone = template.content.cloneNode(true);
            const image = clone.querySelector("img");
            image.src = `public/img/ikonki/add.svg`;
            rightContainer.appendChild(clone);
            if (adds.length == 0)
                throw "empty";
            loadAdds(adds, 1);
            let binButtons = document.querySelectorAll(".binButton");
            binButtons.forEach(button => button.addEventListener("click", deleteAd));
        }).catch((error) => {
        });


    }
    if (option == "option2") {

        fetch(`/likedAdvertisements`).then(function (response) {
            return response.json();

        }).then(function (adds) {
            console.log("111");
            rightContainer.innerHTML = "";
            loadAdds(adds, 2);
            let heartButtons = document.querySelectorAll(".heartButton");
            heartButtons.forEach(button => button.addEventListener("click", like));
            let phoneButtons = document.querySelectorAll(".phoneButton");
            phoneButtons.forEach(button => button.addEventListener("click", displayNumber));

        }).catch((error) => {
            rightContainer.innerHTML = "";
        });

    }
    if (option == "option3") {
        fetch(`/getUserCredentials`).then(function (response) {
            return response.json();
        }).then(function (info) {
            rightContainer.innerHTML = "";
            loadForm(info);
            const completedForm = document.querySelector(".setting-form");
            completedForm.addEventListener("submit", function (event) {
                event.preventDefault();
                sendChanges(completedForm);
            });
        }).catch((error) => {
            rightContainer.innerHTML = "";
        });

    }

}

function sendChanges(event) {

    const formData = new FormData(event);
    const data = Object.fromEntries(formData);
    fetch("/modifyProfile", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });


}

concreteButtons.forEach(button => button.addEventListener("click", manageButtons));
binButtons.forEach(button => button.addEventListener("click", deleteAd));

function like() {

    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    console.log("like");

    let value = null;
    if (clicked.style.backgroundImage == "url(\"/public/img/ikonki/red_heart.png\")" || clicked.style.backgroundImage == "") {

        clicked.style.backgroundImage = "url('/public/img/ikonki/heart.png')";
        value = "unlike";
    }

    const info = {liked: id, option: value};
    fetch("/like", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(info)
    }).then(function (adds) {
        const element = document.getElementById(id);
        element.remove();
    });


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

/*
function displayAdvertisement()
{   const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    console.log(id);
    fetch(`/getAdvertisement/${id}`).then(function (adds)
    {
        console.log(adds);
    });

}
/*
function modifyAd() {
    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");
    fetch(`/modifyAdvertisement/${id}`).then(function (response) {
        // This is the HTML from our response as a text string
      // var  newWindow= window.open("http://localhost:8080/addAdvertisement", "_self");
        var myNewWindow = window.open("/addAdvertisement");
        window.opener.document.getElementById('name').value = "the new value";
        //myNewWindow.document.body.style.background = '#587C68';
       // myNewWindow = window.open("http://localhost:8080/addAdvertisement");
        //myNewWindow.document.body.style.background = color;
        //myNewWindow.document.writeln("<body bgcolor='#587C68'>");

      // newWindow.document.write('written from separate window');
      //  newWindow.document.body.style.background = red;
       // alert(id);
        //print(newWindow.document.getElementsByName("name")[0]);
        //email = newWindow.document.getElementsByName("name")[0]; email.value=''; email.placeholder='new text for email';
    })
}
*/


//gearButtons.forEach(button => button.addEventListener("click", modifyAd));
