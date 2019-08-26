$("#telefone").mask("(00) 0000-00000");

$('.alert').alert();

$(function() {
    $('[data-toggle="tooltip"]').tooltip()
});


$(document).ready(function() {
    //FANCYBOX
    //https://github.com/fancyapps/fancyBox
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
});

function desejos(x) {
    x.classList.toggle("fas");

}