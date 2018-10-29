var hasAudio = localStorage.getItem('audio');

$(document).ready(function () {

    if (!hasAudio) {
        $('#sound').modal({
            'focus': true
        });
    }

    $(document).off("click", ".sound");
    $(document).on("click", ".sound", function () {
        let audio = document.getElementById('player');
        checkAudio(audio);
    });

});

let checkAudio = function (audio) {
    localStorage.setItem('audio', audio.paused);
    if (audio.paused) {
        return audio.play();
    }
    return audio.pause();
}

let playSomMenu = function () {

    if (hasAudio) {
        let somMenu = new Audio();
        somMenu.src = 'assets/sounds/cursor.mp3';

        let promise = somMenu.play();
        if (promise !== undefined) {
            promise.then(_ => {
                return _;
            }).catch(error => {
                console.log('error', error);
            });
        }
    }
}

let characterChoice = function (character) {
    let decision = new Audio();
    decision.src = 'assets/sounds/decision.mp3';
    decision.play();
    $('#characters').fadeOut();
    $('#game').fadeIn();
    $('#menu' + character).show();
}

let attack = function (character){
    
}

let defend = function (character){
    
}