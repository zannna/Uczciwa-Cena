try {
    document.getElementById("alarm").addEventListener('click', function (event) {
        const dropdownContainer = document.querySelector(".dropdown-menu");
        dropdownContainer.innerHTML = "Nowe komentarze:";
        getNotifications(0);

        value2 = 5;
    });
} catch (error) {

}

const dropdownContainer = document.querySelector(".dropdown-menu");

function createNotification(notifications, offset) {

    for (var i = 0; i < notifications.length; i++) {
        loadNotificatons(notifications[i]);
    }
}

function loadNotificatons(notif) {
    const template = document.querySelector("#dropdown-template")
    const clone = template.content.cloneNode(true);
    button = clone.querySelector(".b1");
    button.value = notif.id;
    b1div = clone.querySelector(".b1-div");
    const image = clone.querySelector("img");
    image.src = `/public/uploads/${notif['picture1']}`;
    header = clone.querySelector("p");
    header.innerHTML = notif.name;
    b1div.innerHTML += '<br>' + notif['content'];
    dropdownContainer.appendChild(clone);


}

function getNotifications(off) {
    const info = {offset: off};
    fetch(`/getNotifications`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(info)
        }
    ).then(function (response) {

        return response.json();
    }).then(function (notifications) {
        if (notifications.length > 0) {
            createNotification(notifications, off);
            const dropdownMenu = document.querySelector(".dropdown-menu");
            dropdownMenu.addEventListener('scroll', getnewNotifications);

        }
        const dropdownButtons = document.querySelectorAll(".b1");
        dropdownButtons.forEach(button => button.addEventListener("click", showAd));


    });
}

ok2 = 0;
value2;

function getnewNotifications() {
    dropdown = document.querySelector(".dropdown-menu");
    scrollHeight = dropdown.scrollHeight;
    scrollTop = dropdown.scrollTop;
    clientHeight = dropdown.clientHeight;
    if (scrollHeight - scrollTop - 20 <= clientHeight) {
        if (ok2 == 0) {
            ok2 = 1;
            getNotifications(value2);
            ok2 = 0;
            value2 += 5;

        }
    }
}

function showAd() {
    const clicked = this;
    clicked.name;

}
