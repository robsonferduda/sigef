var host =  $('meta[name="base-url"]').attr('content');
var localGlobal = '';
var setorGlobal = '';

$(".cpf").mask("00000000000");
$(".inscricao").mask("0000000");

$(".btn-excluir").click(function(e) {
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