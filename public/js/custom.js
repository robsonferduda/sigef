var host =  $('meta[name="base-url"]').attr('content');
var localGlobal = '';
var setorGlobal = '';

$(document).on('click', '.btn-confirmar', function(e) {
    e.preventDefault();
    url = $(this).attr('href');
    text = $(this).text().trim();
 
    Swal.fire({
        title: "Tem certeza que deseja excluir "+text+"?",
        text: "Essa operação não pode ser revertida",
        icon: "warning",
        confirmButtonColor: '#1BC5BD',
        showCancelButton: true,
        cancelButtonText: '<i class="fa fa-times text-white"></i> Cancelar',
        confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, excluir'
    }).then(function(result) {
        if (result.value) {
            window.location = url;
        }
    });
});

$(".btn-frm-excluir").click(function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
        title: "Tem certeza que deseja excluir esse registro?",
        text: "Essa operação não pode ser revertida",
        icon: "warning",
        confirmButtonColor: '#1BC5BD',
        showCancelButton: true,
        cancelButtonText: '<i class="fa fa-times text-white"></i> Cancelar',
        confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, excluir'
    }).then(function(result) {
        if (result.value) {
            form.submit();
        }
    });
});

$(document).on('click', '.btn-excluir', function(e) {

    id = $(this).attr("id");

    Swal.fire({
        title: "Tem certeza que deseja excluir esse registro?",
        text: "Essa operação não pode ser revertida",
        icon: "warning",
        confirmButtonColor: '#1BC5BD',
        showCancelButton: true,
        cancelButtonText: '<i class="fa fa-times text-white"></i> Cancelar',
        confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, excluir'
    }).then(function(result) {
        if (result.value) {
            var url = host+'/local/'+id+'/excluir';
            location = url;
        }
    });
});

$.ajax({
    url: host+'/eventos/listar',
    type: 'GET',
    success: function(data) {

        $.each(data, function(index, value) {
            $("#evento")
            .append($("<option></option>")
                    .attr("value", value.cd_evento_eef)
                    .text(value.cd_evento_eve +' - '+ value.nm_evento_eef));
        });

    },
    error: function(response){

        Swal.fire({
            title: "Erro ao carregar eventos",
            text: "Houve um erro ao carregar os eventos disponíveis",
            type: "error",
            icon: "error",
            showCancelButton: false,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Ok"
        });
        
    }
});

$("#btn-alterar-evento").click(function(e) {
    
    var evento = $("#evento").val();
    var token = $('meta[name="csrf-token"]').attr('content');
    $(".error-evento").empty();

    if(!evento){
        $(".error-evento").html("Obrigatório selecionar um evento");
    }else{

        $.ajax({
            url: host+'/evento/alterar',
            type: 'POST',
            data: { "_token": token,
                    "evento": evento },
            success: function(response) {
                window.location.reload();
            }
        });
    }
});