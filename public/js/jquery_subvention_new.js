// Ajouter Paramètre dans Subvention****************************************************************************************************
var select = $('#type-subvention-select').change("change", displayCheck);
// var select = $('#type-subvention-select').getElementById("type-subvention-select").value;
// console.log(select)
function displayCheck() {
    if (select.val() !== "Fonctionnement") {
        $('#form-param-subv-new').show();
        $('#empl-boutton-param').show();

    } else {
        $('#form-param-subv-new').hide();
        $('#empl-boutton-param').hide();
    }
}

var btnAjoutParametre = document.querySelector('#btn-ajout-param');
btnAjoutParametre.addEventListener('click', addBtn);

var parametrages = $('#result').val();
console.log(parametrages);

var compteur = 0;
var compteurLabel = 1;
function addBtn() {

    console.log(compteur);

    if (compteur < 10){
        compteur++;
        compteurLabel++;
        $('#compteur').attr('value',compteur)
        $('#nouveau-param').append('                <div id="div-param'+ compteur +'">\n' +
            '                    <h5>Paramètre '+ compteurLabel +'</h5>\n' +
            '                            <div class="form-group">\n' +
            '                                <label for="parametrage-select">Type Demande Nature</label>\n' +
            '                                <select class="form-control" name="parametrage-select'+ compteur +'" id="parametrage-select">\n' +
            '                                        <option value="1">Km Minibus</option>\n' +
            '                                        <option value="2">Moment Convivialité Personnes</option>\n' +
            '                                        <option value="3">Moment Convivialité VIP</option>\n' +
            '                                        <option value="4">Médaille(s)</option>\n' +
            '                                        <option value="5">Coupe(s)</option>\n' +
            '                                        <option value="6">Autre</option>\n' +
            '                                </select>\n' +
            '                            </div>\n' +
            '                            <div class="form-group">\n' +
            '                                <label for="name-param0">Nom </label>\n' +
            '                                <input type="text" class="form-control" name="name-param'+ compteur +'" id="name-param">\n' +
            '                            </div>\n' +
            '                            <div class="form-group">\n' +
            '                                <label for="valorisation-param0">Valeur </label>\n' +
            '                                <input type="number" class="form-control" name="valorisation-param'+ compteur +'" id="valorisation-param">\n' +
            '                            </div>\n' +
            '                            <div class="form-group">\n' +
            '                                <label for="unite-param0">Unité (Km, personnes, VIP, Médailles, Coupes, etc...)</label>\n' +
            '                                <input type="text" class="form-control" name="unite-param'+ compteur +'" id="unite-param">\n' +
            '                            </div>\n' +
            '                </div>');
    }
}

var btnSuppParametre = document.querySelector('#btn-supp-param');
btnSuppParametre.addEventListener('click', deleteBtn);

function deleteBtn() {
    $('#' + 'div-param'+ compteur).remove();
    compteur--;
    $('#compteur').attr('value',compteur)
}




































