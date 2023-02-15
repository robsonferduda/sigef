$(function () {

    $("#fl_senha").change(function(){

        if(this.checked) {
            $(".box_senha").removeClass('box_altera_senha');
        }else{
            $(".box_senha").addClass('box_altera_senha');
        }
    });

    var socket  = io('http://localhost:8888');

    $('#like').click(function(event){
        event.preventDefault();
        var self = $(this);
        // Envio um AJAX para o Laravel
        $.ajax({
           url: 'http://localhost:8888/like',
           type: "POST",
           data: {
              name    : self.data('name'),
              id      : me
           },
           success: function(result){
              console.log('Sucesso!');
           }
         });
    });

     // Registra usuário no Socket
    socket.on('welcome', function(data){
        me = data.id;
    });

    socket.on('idcoperve/users', function(response){
        
    });

});