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
    $('.msg' + escolha).html('');
    $('.msg' + outro).html('');
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
            $('#atacante').val(outro);
            stroke(outro, escolha);
        }
        if (gamer > enemy) {
            $('.msg' + escolha).html('Ataca Primeiro');
            $('#atacante').val(escolha);
            stroke(escolha, outro);
        }
    }, 1000);
    return false;
}

const iniciativa = function (character) {
    return $.get('/v1/battle/dice/' + character);
}

const viewDiceBattle = function (value) {
    $('.dice.battle').html(value);
}

const stroke = async function (attack, defense) {
    setTimeout(function () {
        ataque(attack).done(function (data) {
            $('.msg' + attack).html('Ataque: ' + data);
            $('#inputAtkDef' + attack).val(data);
        });
        defesa(defense).done(function (data) {
            $('.msg' + defense).html('Defesa: ' + data);
            $('#inputAtkDef' + defense).val(data);
        });
        damage();
    }, 1000);
    return false;
}

const ataque = function (character) {
    return $.get('/v1/battle/attack/' + character);
}

const defesa = function (character) {
    return $.get('/v1/battle/defense/' + character);
}

const damage = async function () {
    setTimeout(function () {
        let attack = $('#atacante').val();
        let defense = attack === 'Human' ? 'Orc' : 'Human';

        let atk = $('#inputAtkDef' + attack).val();
        let def = $('#inputAtkDef' + defense).val();

        if (atk > def) {
            dano(attack).done(function (data) {
                let progress = $('#progress' + defense);
                let max = parseInt(progress.attr('aria-valuemax'));
                let total = parseInt(progress.attr('aria-valuenow'));
                let restante = total - data;
                progress.attr('aria-valuenow', restante);
                let width = Math.round(100 / (max - restante))
                progress.attr('style', 'width: ' + width + '%;');
                $('.msg' + defense).html('Recebeu ' + data + ' de dano!!!');
                $('.msg' + attack).html('');
                console.log(max, restante, width);
                if (restante <= 0) {
                    setTimeout(function () {
                        $('.msg' + defense).html('');
                        $('.msg' + attack).html('Você venceu!!!');
                    }, 1000);
                    return false;
                }
            });
        } else {
            $('.msg' + defense).html('Defendeu!!!');
            $('.msg' + attack).html('');
        }
        setTimeout(function () {
            $('#battledice').data('dice', defense);
            start($('#battledice'));
        }, 1000);

    }, 1000);
    return false;
}

const dano = function (character) {
    return $.get('/v1/battle/damage/' + character);
}