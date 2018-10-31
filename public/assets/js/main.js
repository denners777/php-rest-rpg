const hasAudio = localStorage.getItem('audio');

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

const checkAudio = function (audio) {
    localStorage.setItem('audio', audio.paused);
    if (audio.paused) {
        return audio.play();
    }
    return audio.pause();
}

const playSomMenu = function () {

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

const characterChoice = function (character) {
    let decision = new Audio();
    decision.src = 'assets/sounds/decision.mp3';
    decision.play();
    $('#characters').fadeOut();
    $('#game').fadeIn();
    $('#battledice').data('dice', character);
}

const start = function (e) {
    let elemento = $(e);
    elemento.hide();
    let escolha = elemento.data('dice');
    let outro = escolha === 'Human' ? 'Orc' : 'Human';

    iniciativa().done(function (data) {
        $('.dice.battle').html(data);
        $('#numberDice' + escolha).html("<span class='badge badge-warning'>" + data + "</span>");
        $('#inputNumberDice' + escolha).val(data);
    });
    iniciativa().done(function (data) {
        $('.dice.battle').html(data);
        $('#numberDice' + outro).html("<span class='badge badge-warning'>" + data + "</span>");
        $('#inputNumberDice' + outro).val(data);
    });
    
}

const iniciativa = function () {
    return $.get('/v1/battle/dice/20');
}