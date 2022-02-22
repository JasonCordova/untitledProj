function checkInput(){
    
    var currentInput = this;
        
    if (currentInput.value.length > 0){

        currentInput.classList.add("upd-input");

    } else {

        currentInput.classList.remove("upd-input");

    }

}

function checkAllInputs(){

    var allBasicInput = document.getElementsByClassName("basic-form-input");
    for (i = 0; i < allBasicInput.length; i++){

        var currentInput = allBasicInput[i];
        currentInput.addEventListener("input", checkInput);
        
        if (currentInput.value.length > 0){

            currentInput.classList.add("upd-input");

        } else {

            currentInput.classList.remove("upd-input");

        }

    }

}

function showInvis(){

    var allInvisible = document.getElementsByClassName("invis");
    console.log(allInvisible);
    for (i = 0; i < allInvisible.length; i++){

        var currentElement = allInvisible[i];

        currentElement.classList.remove("invis");

    }

}

function onload(){

    checkAllInputs();
    showInvis();

}

function showChatrooms(){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("chatroom-holder").innerHTML = this.responseText;

        }

    };

    xmlhttp.open("GET", "show-chatrooms.php", true);
    xmlhttp.send();

}

function showUsers(e){

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById("user-holder").innerHTML = this.responseText;

        }

    };

    xmlhttp.open("GET", "show-users.php?name=" + e.value, true);
    xmlhttp.send();

}