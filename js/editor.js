function deletePost(){
if (confirm('Estás seguro de querer borrar el post? esta acción es permanente.')) {
    realizaProceso('eliminar');
        } else {
   return null;
        }
}

function realizaProceso(action){
        var id = $('#id').val();
        var titulo = $('#title').val();
        var fecha = $('#date').val();
        var estado = $('#state').val();
        var contenido = $('#content').val();
        var accion = action;

        var parametros = {
                "id" : id,
                "titulo" : titulo,
                "fecha" : fecha,
                "estado" : estado,
                "contenido" : contenido,
                "accion" : accion
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   './php/processPost.php', //archivo que recibe la peticion
                type:  'post', //método de envio
                beforeSend: function () {
                        $("#resultado").html("Procesando, espere por favor...");
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                        $("#resultado").html(response);
                }
        });
}