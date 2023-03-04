binButtons = document.querySelectorAll(".binButton");
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

    }

    const div = clone.querySelector("div");
    div.id = add.id
    if (add.picture1 != "") {
        const image = clone.querySelector("img");
        image.src = `/public/uploads/${add.picture1}`;
    }
    rightContainer.appendChild(clone);


}

function loadAdds(adds, option) {

    adds.forEach(add => {
        createAdd(add, option);
    });

}

function loadForm(info) {
    const template = document.querySelector("#domek");
    clone = template.content.cloneNode(true);
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
    if(window.mobileCheck()==true)
    {
        rightContainer.style.display="flex";
        navigation=document.querySelector("nav2");
        navigation.style.display="none";
    }
}

window.mobileCheck = function() {
    check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};


function manageButtons() {

    const clicked = this;
    concreteButtons.forEach(button => button.style.background = "#EAEAEA");
    this.style.background = "#AB9D91";
    option = clicked.getAttribute("id");
    if (option == "option1") {
        fetch(`/getUserAdvertisements/js`).then(function (response) {
            return response.json();
        }).then(function (adds) {
            rightContainer.innerHTML = "";
            body=document.querySelector("body");
            body.style.overflow="auto";
            if(window.mobileCheck()==true)
            {
                rightContainer.style.display="flex";
                navigation=document.querySelector("nav2");
                navigation.style.display="none";
                name= document.createElement('div');
                name.classList.add('option-name');
                content = document.createTextNode("moje ogłoszenia");
                name.appendChild(content);
                rightContainer.appendChild(name);

            }
            const template = document.querySelector("#user-addButton-template");
            clone = template.content.cloneNode(true);
            const image = clone.querySelector("img");
            image.src = `public/img/ikonki/add.svg`;
            rightContainer.appendChild(clone);
            if (adds.length == 0)
                throw "empty";
            loadAdds(adds, 1);
            binButtons = document.querySelectorAll(".binButton");
            binButtons.forEach(button => button.addEventListener("click", deleteAd));
        }).catch((error) => {
        });


    }
    if (option == "option2") {

        fetch(`/likedAdvertisements`).then(function (response) {
            return response.json();
        }).then(function (adds) {
            body=document.querySelector("body");
            body.style.overflow="auto";
            rightContainer.innerHTML = "";
            if(window.mobileCheck()==true)
            {
                rightContainer.style.display="flex";
                navigation=document.querySelector("nav2");
                navigation.style.display="none";
                name= document.createElement('div');
                name.classList.add('option-name');
                content = document.createTextNode("polubione");
                name.appendChild(content);
                rightContainer.appendChild(name);

            }

           loadAdds(adds, 2);
            heartButtons = document.querySelectorAll(".redHeartButton");
            heartButtons.forEach(button => button.addEventListener("click", like));
            phoneButtons = document.querySelectorAll(".phoneButton");
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
    }).then(function (response) {
        return response.json();
    }).then(function (number) {
      window.location.reload();
    });




}

concreteButtons.forEach(button => button.addEventListener("click", manageButtons));
binButtons.forEach(button => button.addEventListener("click", deleteAd));

function like() {

    const clicked = this;
    const container = clicked.parentElement.parentElement.parentElement;
    const id = container.getAttribute("id");


    value = null;
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
    phone = 0;
    fetch("/getPhoneNumber", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
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

    });


}


