function eliminar_periodo(id_periodo_intercambio)
{
  if (confirm('Seguro queres eliminar el periodo ?')) 
  {

     $.ajax({
                url: CI_ROOT+'index.php/universidad/eliminar_periodo_intercambio',
                data: { id_periodo_intercambio: id_periodo_intercambio },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  if(data.error == false)
                  {
                    alert("Se ha eliminado el periodo de eliminar_periodo_intercambio");
                    location.reload();
                  }
                  else
                  {
                    alert("No se ha eliminado el periodo");
                    location.reload();
                  }
                },
                error: function(x, status, error){
                  alert("error");
                }
          });
  }
}