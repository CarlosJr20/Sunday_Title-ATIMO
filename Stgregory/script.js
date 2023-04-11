
$(document).ready(function(){
    var url = "https://church.saintgreg.org/ctm/31250/projects/StGregory/layout01/php/bulletins.php";
    $.ajax({
        type: "GET",
        dataType: 'text',
        url: url,
        success: function(data) {
            var informacao = data.trim();
            // Atualizar o conteúdo do h2 dentro da div
            $('#bulletin h2').text(informacao);
        },
        error: function() {
            console.error("Erro ao carregar o arquivo.");
        }
    });
});

