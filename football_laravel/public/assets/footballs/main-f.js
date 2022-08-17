
function onchangeCss(input){
    $(input).removeClass('is-invalid');
    $(input).next().attr('style','display:none;');
}

function printErrors(errors) {
    for (let [key, value] of Object.entries(errors)) {
        $("#error_"+key).prev().addClass("is-invalid")
        $("#error_"+key).replaceWith(`<span class="error invalid-feedback" id="error_${key}">${value[0]}</span>`);
    }
}
