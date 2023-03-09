var host =  $('meta[name="base-url"]').attr('content');
var localGlobal = '';
var setorGlobal = '';

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