/*hidden input*/
document.getElementById('undo').addEventListener("click", open);
document.getElementById('addButton').addEventListener('click', openDialog);
function openDialog() {
    document.getElementById('files').click();
}
function open()
{
    location.replace(`/getUserAdvertisements`);
}
/*text area
function vh(percent) {
    var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    return (percent * h) / 100;
}

const tx = document.getElementsByTagName("textarea");
for (let i = 0; i < tx.length; i++) {
    tx[i].setAttribute("style", "height:" + (tx[i].scrollHeight) + "px;overflow-y:hidden;");
    tx[i].addEventListener("input", OnInput, false);
}
function OnInput() {
    this.style.height = 0;
    this.style.height = this.scrollHeight*2 + "px";
}
*/
/*addPicture*/
document.querySelector("#files").addEventListener("change", (e) => {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        const files = e.target.files;
        const output = document.querySelector("#result");
        output.innerHTML = "";
        for (let i = 0; i < files.length; i++) {
            if (!files[i].type.match("image")) continue;
            const picReader = new FileReader();
            picReader.addEventListener("load", function (event) {
                const picFile = event.target;
                const div = document.createElement("div");
                div.innerHTML = `<img class="thumbnail" src="${picFile.result}" title="${picFile.name}"/>`;
                output.appendChild(div);
            });
            picReader.readAsDataURL(files[i]);
        }
    } else {
        alert("Your browser does not support File API");
    }
});

