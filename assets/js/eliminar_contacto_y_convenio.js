
function eliminar_convenio(id_convenio)
{
  if (confirm('Seguro queres eliminar el convenio ?')) 
  {

     $.ajax({
                url: CI_ROOT+'index.php/universidad/eliminar_convenio',
                data: { id_convenio: id_convenio },
                async: true,
                type: 'POST',
                dataType: 'JSON',
                success: function(data)
                {
                  if(data.error == false)
                  {
                    alert("Se ha eliminado el convenio");
                    location.reload();
                  }
                  else
                  {
                    alert("No se ha eliminado el convenio, intente mas tarde.");
                  }
                },
                error: function(x, status, error){
                  alert("error");
                }
          });
  }
}

function eliminar_contacto(id_contacto)
{
  if (confirm('Seguro que desea eliminar el contacto?')) 
  {
      $.ajax({
              url: CI_ROOT+'index.php/universidad/eliminar_contacto',
              data: { id_contacto: id_contacto },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  alert("Se ha eliminado el contrato exitosamente");
                  location.reload();
                }
                else
                {
                  alert("No se ha eliminado el contrato, intente mas tarde");
                }
              },
              error: function(x, status, error){
                alert("error");
              }
        });

  } 
}
 

function eliminar_certificado_experiencia(id_experiencia, id_certificado )
{
  if (confirm('Seguro queres eliminar el certificado ?')) 
  {
      $.ajax({
              url: CI_ROOT+'index.php/universidad/eliminar_certificado_experiencia',
              data: { id_experiencia: id_experiencia, id_certificado: id_certificado  },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  alert("Se ha eliminado el certificado de la experiencia");
                  location.reload();
                }
                else
                {
                  alert("No se ha eliminado el certificado de la experiencia, intente mas tarde.");
                }
              },
              error: function(x, status, error){
                alert("error");
              }
        });

  } 
}

function eliminar_programa_experiencia(id_experiencia, c_identificacion, c_programa, c_orientacion )
{
  if (confirm('Seguro queres eliminar el programa de la experiencia ?')) 
  {
      $.ajax({
              url: CI_ROOT+'index.php/universidad/eliminar_programa_experiencia',
              data: { id_experiencia: id_experiencia, c_identificacion: c_identificacion, c_programa: c_programa, c_orientacion: c_orientacion  },
              async: true,
              type: 'POST',
              dataType: 'JSON',
              success: function(data)
              {
                if(data.error == false)
                {
                  alert("Se ha eliminado el programa de la experiencia");
                  location.reload();
                }
                else
                {
                  alert("No se ha eliminado el programa de la experiencia");
                }
              },
              error: function(x, status, error){
                alert("error");
              }
        });

  } 
}


