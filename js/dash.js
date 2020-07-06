function deletePost(id){
if (confirm('Are you sure you want to delete this post? this action is permanent.')) {
    realizaProceso('eliminar',id);
        } else {
   return null;
        }
}

function realizaProceso(action, id){
        var accion = action;
        var registro = "#registro" + id.toString();
        var parametros = {
                "id" : id,
                "accion" : accion
        };
        $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   './php/processPost.php', //archivo que recibe la peticion
                type:  'post', //método de envio
                beforeSend: function () {
                    $(registro).addClass( "updating" );
                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                    $(registro).hide();
                },
                error: function(){
                	$(registro).addClass( "error" );
                }
        });
}
