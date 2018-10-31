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
    $('.msg').html('');
    let elemento = $(e);
    elemento.hide();
    let escolha = elemento.data('dice');
    let outro = escolha === 'Human' ? 'Orc' : 'Human';
    iniciativa(escolha).done(function (data) {
        viewDiceBattle(data);
        $('#numberDice' + escolha).html("<span class='badge badge-warning'>" + data + "</span>");
        $('#inputNumberDice' + escolha).val(data);
    });
    iniciativa(outro).done(function (data) {
        viewDiceBattle(data);
        $('#numberDice' + outro).html("<span class='badge badge-warning'>" + data + "</span>");
        $('#inputNumberDice' + outro).val(data);
    });
    setTimeout(function () {
        let gamer = parseInt($('#inputNumberDice' + escolha).val());
        let enemy = parseInt($('#inputNumberDice' + outro).val());
        if (gamer === enemy) {
            start(e);
        }
        if (gamer < enemy) {
            $('.msg' + outro).html('Ataca Primeiro');
            stroke(outro, escolha);
        }
        if (gamer > enemy) {
            $('.msg' + escolha).html('Ataca Primeiro');
            stroke(escolha, outro);
        }
    }, 1000);
}

const iniciativa = function (character) {
    return $.get('/v1/battle/dice/' + character);
}

const viewDiceBattle = function (value) {
    $('.dice.battle').html(value);
}

const stroke = function (attack, defense) {
    setTimeout(function () {
        ataque(attack).done(function (data) {
            $('.msg' + attack).html('Ataque: ' + data);
            $('#inputAtkDef' + attack).val(data);
        });
        defesa(defense).done(function (data) {
            $('.msg' + defense).html('Defesa: ' + data);
            $('#inputAtkDef' + defense).val(data);
        });
    }, 1000);
}

const ataque = function (character) {
    return $.get('/v1/battle/attack/' + character);
}

const defesa = function (character) {
    return $.get('/v1/battle/defense/' + character);
}