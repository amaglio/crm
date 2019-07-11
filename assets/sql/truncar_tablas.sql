create or replace PROCEDURE TRUNCAR_TABLAS_CRM AS 
BEGIN

-- Por si algo falla
SAVEPOINT sp_sptest;

------------------ CONTACTO WEB ------------------

execute immediate 'TRUNCATE TABLE CRM_CONTACTO_WEB';
execute immediate 'TRUNCATE TABLE CRM_CONTACTO_WEB_CONTACTENLO';
execute immediate 'TRUNCATE TABLE CRM_CONTACTO_WEB_INFO_INTERES';
execute immediate 'TRUNCATE TABLE CRM_CONTACTO_WEB_PER_ING';
execute immediate 'TRUNCATE TABLE CRM_CONTACTO_WEB_PRG_INT';


------------------  PERSONAS ------------------

execute immediate 'TRUNCATE TABLE CRM_PERSONA';
execute immediate 'TRUNCATE TABLE CRM_PERSONA_DOCUMENTO';
execute immediate 'TRUNCATE TABLE CRM_PERSONA_EDUCACION';
execute immediate 'TRUNCATE TABLE CRM_PERSONA_EMAIL';
execute immediate 'TRUNCATE TABLE CRM_PERSONA_EMPRESA';
execute immediate 'TRUNCATE TABLE CRM_PERSONA_LOG';
execute immediate 'TRUNCATE TABLE CRM_PERSONA_TELEFONO';
execute immediate 'TRUNCATE TABLE CRM_INTERESADO';


----------------  ESCUELA DE NEGOCIO ------------------

execute immediate 'TRUNCATE TABLE CRM_REFERENTE_EMPRESA';
execute immediate 'TRUNCATE TABLE CRM_ACCION';
execute immediate 'TRUNCATE TABLE CRM_ACCION_RESULTADO';
execute immediate 'TRUNCATE TABLE CRM_ACUERDO';

----------------  CONSULTA ------------------

execute immediate 'TRUNCATE TABLE CRM_COMENTARIO_CONSUL_PRG';
execute immediate 'TRUNCATE TABLE CRM_CON_PRG_SOLICITUD';
execute immediate 'TRUNCATE TABLE CRM_CONS_PERIODO_INGRESO';
execute immediate 'TRUNCATE TABLE CRM_CONSULTA';
execute immediate 'TRUNCATE TABLE CRM_CONSULTA_CONTACTENME';
execute immediate 'TRUNCATE TABLE OPERADOR_A_CARGO';
execute immediate 'TRUNCATE TABLE OPERADOR_PROGRAMA';
execute immediate 'TRUNCATE TABLE CRM_CONSULTA_INFO_INTERES';
execute immediate 'TRUNCATE TABLE CRM_CONSULTA_LOG';
execute immediate 'TRUNCATE TABLE CRM_CONSULTA_PROGRAMA';
execute immediate 'TRUNCATE TABLE CRM_EMAIL_CONSULTA';
execute immediate 'TRUNCATE TABLE CRM_EMAIL_PLANTILLA';

	EXCEPTION
	  WHEN OTHERS THEN
	    -- We roll back to the savepoint.

	    ROLLBACK TO sp_sptest;
	    -- And of course we raise again,
	    -- since we don't want to hide the error.
	    -- Not raising here is an error!
	    RAISE; 


END TRUNCAR_TABLAS_CRM;