function deletePost(id){
        if (confirm('Are you sure you want to delete this post? this action is permanent.')) {
            realizaProceso('eliminar');
                } else {
           return null;
                }
        }

function realizaProceso(action) {
        var id = $('#id').val();
        var titulo = $('#title').val();
        var fecha = $('#date').val();
        var estado = $('#state').val();
        var contenido = encodeURI($('#content').val());
        var accion = action;

        var parametros = {
                "id": id,
                "titulo": titulo,
                "fecha": fecha,
                "estado": estado,
                "contenido": contenido,
                "accion": accion
        };
        $.ajax({
                data: parametros, //datos que se envian a traves de ajax
                url: './php/processPost.php', //archivo que recibe la peticion
                type: 'post', //método de envio
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success: function (response) {
                        location.href = response;
                }
        });
}
