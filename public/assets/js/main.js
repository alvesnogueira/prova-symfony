$(document).ready(function() {

    var url = "http://www.geonames.org/childrenJSON?geonameId=3469034";
    $.getJSON(url, function(json){
        var $select_elem = $("#uf");
        $select_elem.empty();
        $.each(json.geonames, function (idx, obj) {
            //obj.adminCodes1.ISO3166_2
            $select_elem.append('<option value="' + obj.geonameId + '">' + obj.adminName1 + '</option>');
        });
        $select_elem.chosen({ width: "95%" });
    });
    $('input[name=cep]').mask("99.999-999");
});


function listPlaces(jData)
{
    var $select_elem = $("#cidade");
    $select_elem.chosen("destroy");

    $select_elem.empty();
    $.each(jData.geonames, function (idx, obj) {
            $select_elem.append('<option value="' + obj.geonameId + '">' + obj.name + '</option>');
    });
    $select_elem.chosen({ width: "95%" });

}

function buscaCep(cep)
{
    var cepAux = $.trim(cep);
    var cepUnmasked = cepAux.replace("-","");
    cepUnmasked = cepUnmasked.replace(".","");
    var url = 'https://viacep.com.br/ws/'+cepUnmasked+'/json/';
    $.getJSON(url, function(retorno){
        $('input[name=bairro]').attr('readonly', true);
        $('input[name=logradouro]').attr('readonly', true);
        if(retorno.erro)
        {
            alert('CEP não localizado');
            $('#bairro').attr('readonly', false);
            $('#logradouro').attr('readonly', false);
            $("#bairro").val('');
            $("#logradouro").val('');
            return false;
        }
        if (retorno.logradouro == '')
        {
            $('input[name=bairro]').attr('readonly', false);
            $('input[name=logradouro]').attr('readonly', false);
        }
        else
        {
            $("#bairro").val(retorno.bairro);
            $("#logradouro").val(retorno.logradouro);

        }
    });

}
$(".change-cidade").on('change', function(){
    var geonameId = $('#uf option:selected').val();

    $.ajax({
        url: 'http://www.geonames.org/childrenJSON',
        dataType: 'html', // TIPO DE RETORNO
        type: 'get',    // TIPO DE ENVIO POST OU GET
        async: true,   // REQUISIÇÃO SINCRONA OU ASSINCRONOA
        data: {
            geonameId: geonameId,
            callback: 'listPlaces'
        },  // PARAMETROS A SEREM ENVIADOS
        success: function(retorno)
        {
            //Infelismente a api retorna um json function
            eval(retorno);

        },
        error: function(request, status, error)
        {
             console.log(request);
             console.log(status);
             console.log(error);
        }
    });
});

$("#btn-buscar-cep").on('click', function(){
   if($("#cep").valid())
   {
        var  cep = $("#cep").val();
        buscaCep(cep);
   }
});
$("#cadastro").validate({
    // Define as regras
        onkeyup: false,
        errorClass: 'help-block',
        rules:{
                cep:{
                    required: true,
                },
                nome:{
                    required: true,
                }
        },
        messages: {
            nome: {
                required: "Informe seu nome.",
            },
            cep: {
                required: "Informe seu cep.",
            }
        },
        // Define as mensagens de erro para cada regra
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
            $(element).closest('.form-group').find('span.fa').remove();
            $(element).closest('.form-group').append('<span class="fa fa-warning form-control-feedback"></span>');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
            $(element).closest('.form-group').find('span.fa').remove();
            $(element).closest('.form-group').append('<span class="fa fa-check form-control-feedback"></span>');
        },
    });