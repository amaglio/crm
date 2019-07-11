function eliminar_experiencia(id_experiencia)
{
  if (confirm('Seguro queres eliminar la experiencia internacional ?')) 
  {

     $.ajax({
                url: CI_ROOT+'index.php/universidad/eliminar_experiencia_internacional',
                data: { id_experiencia: id_experiencia },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  if(data.error == false)
                  {
                    alert("Se ha eliminado la experiencia");
                    location.reload();
                  }
                  else
                  {
                    alert("No se ha eliminado la experiencia");
                    location.reload();
                  }
                },
                error: function(x, status, error){
                  alert("error");
                }
          });
  }
}