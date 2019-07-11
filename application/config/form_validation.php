<?php
$config = array(

             'loguearse' => array(
                                    array(
                                            'field' => 'usuario',
                                            'label' => 'usuario',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'clave',
                                            'label' => 'clave',
                                            'rules' => 'required|trim|xss_clean'
                                        )
                                ),

            'agregar_programa' => array(
                                    array(
                                            'field' => 'c_identificacion',
                                            'label' => 'c_identificacion',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'c_programa',
                                            'label' => 'c_programa',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'c_orientacion',
                                            'label' => 'c_orientacion',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_persona',
                                            'label' => 'id_persona',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        )
                                ),

            'eliminar_programa' => array(
                                    array(
                                            'field' => 'c_identificacion',
                                            'label' => 'c_identificacion',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'c_programa',
                                            'label' => 'c_programa',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'c_orientacion',
                                            'label' => 'c_orientacion',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'id_persona',
                                            'label' => 'id_persona',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        )
                                ),

            'crear_convenio' => array(
                                    array(
                                            'field' => 'id_universidad',
                                            'label' => 'id_universidad',
                                            'rules' => 'required|trim|xss_clean|numeric'
                                        ),
                                    array(
                                            'field' => 'comentario',
                                            'label' => 'comentario',
                                            'rules' => 'trim|xss_clean'
                                        )
                                ),

            'editar_convenio' => array(
                                        array(
                                                'field' => 'id_convenio',
                                                'label' => 'id_convenio',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'comentario',
                                                'label' => 'comentario',
                                                'rules' => 'trim|xss_clean'
                                            )
                                ),

            'eliminar_convenio' => array(
                                            array(
                                                    'field' => 'id_convenio',
                                                    'label' => 'id_convenio',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                )
                                ),

             'crear_contacto' => array(
                                        array(
                                                'field' => 'email',
                                                'label' => 'email',
                                                'rules' => 'trim|xss_clean|valid_email'
                                            ),
                                        array(
                                                'field' => 'id_universidad',
                                                'label' => 'id_universidad',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'editar_contacto' => array(
                                        array(
                                                'field' => 'id_contacto',
                                                'label' => 'id_contacto',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

        'eliminar_contacto' => array(
                                        array(
                                                'field' => 'id_contacto',
                                                'label' => 'id_contacto',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


        'buscar_contacto' => array(
                                        array(
                                                'field' => 'dato_buscado',
                                                'label' => 'dato_buscado',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

        'ver_contacto' => array(
                                        array(
                                                'field' => 'id_crm_persona',
                                                'label' => 'id_crm_persona',
                                                'rules' => 'required|trim|xss_clean|numeric|callback_comprobar_persona_crm_existente_validation'
                                            )
                                ),


        'alta_educacion_contacto' => array(

                                        array(
                                                'field' => 'id_nivel',
                                                'label' => 'id_nivel',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_crm_persona',
                                                'label' => 'id_crm_persona',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

        'modifica_educacion_contacto' => array(

                                        array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_nivel',
                                                'label' => 'id_nivel',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_educacion_crm',
                                                'label' => 'id_educacion_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


         'baja_educacion_contacto' => array(

                                        array(
                                                'field' => 'id_educacion_crm',
                                                'label' => 'id_educacion_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


           'alta_email_contacto' => array(

                                        array(
                                                'field' => 'email',
                                                'label' => 'email',
                                                'rules' => 'required|trim|xss_clean|callback_existe_email_validation'
                                            ),
                                        array(
                                                'field' => 'id_tipo_email',
                                                'label' => 'id_tipo_email',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

             'modifica_email_contacto' => array(

                                        array(
                                                'field' => 'email',
                                                'label' => 'email',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_tipo_email',
                                                'label' => 'id_tipo_email',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_email_crm',
                                                'label' => 'id_email_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


            'baja_email_contacto' => array(

                                        array(
                                                'field' => 'id_email_crm',
                                                'label' => 'id_email_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),






            'alta_telefono_contacto' => array(

                                        array(
                                                'field' => 'telefono',
                                                'label' => 'telefono',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_tipo_telefono',
                                                'label' => 'id_tipo_telefono',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

             'modifica_telefono_contacto' => array(

                                        array(
                                                'field' => 'telefono',
                                                'label' => 'telefono',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_tipo_telefono',
                                                'label' => 'id_tipo_telefono',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_telefono_crm',
                                                'label' => 'id_telefono_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


            'baja_telefono_contacto' => array(

                                        array(
                                                'field' => 'id_telefono_crm',
                                                'label' => 'id_telefono_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'asignar_info_interes' => array(

                                        array(
                                                'field' => 'id_info_interes[]',
                                                'label' => 'id_info_interes[]',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                         array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


            'modifica_periodo_ingreso' => array(

                                        array(
                                                'field' => 'anio',
                                                'label' => 'anio',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                         array(
                                                'field' => 'id_periodo',
                                                'label' => 'id_periodo',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                         array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


            'tomar_consulta' => array(

                                         array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'modificar_estado_consulta' => array(

                                         array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                           array(
                                                'field' => 'id_estado_consulta',
                                                'label' => 'id_estado_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'modificar_como_contactar' => array(

                                         array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),

                                        array(
                                                'field' => 'id_contactenme[]',
                                                'label' => 'id_contactenme[]',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'modificar_programas' => array(

                                         array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),

                                        array(
                                                'field' => 'id_codigo[]',
                                                'label' => 'id_codigo[]',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'enviar_email_consulta' => array(

                                         array(
                                                'field' => 'email',
                                                'label' => 'email',
                                                'rules' => 'required|xss_clean'
                                            ),

                                        array(
                                                'field' => 'mensaje_email',
                                                'label' => 'mensaje_email',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),


            'agregar_comentario_programa' => array(

                                        array(
                                                'field' => 'id_crm_consulta_programa',
                                                'label' => 'id_crm_consulta_programa',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                         array(
                                                'field' => 'comentario',
                                                'label' => 'comentario',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

             'agregar_comentario_general' => array(

                                        array(
                                                'field' => 'id_crm_consulta',
                                                'label' => 'id_crm_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                         array(
                                                'field' => 'comentario',
                                                'label' => 'comentario',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),



            'desestimar_programa' => array(

                                        array(
                                                'field' => 'id_crm_consulta_programa',
                                                'label' => 'id_crm_consulta_programa',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


            'ver_alta_consulta_2' => array(

                                        array(
                                                'field' => 'apellido',
                                                'label' => 'apellido',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'email',
                                                'label' => 'email',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

             'ver_alta_consulta_3' => array(

                                        array(
                                                'field' => 'datos_persona',
                                                'label' => 'datos_persona',
                                                'rules' => 'required|trim'
                                            )
                                ),

            'alta_consulta' => array(

                                        array(
                                                'field' => 'datos_persona',
                                                'label' => 'datos_persona',
                                                'rules' => 'required|trim'
                                            )
                                ),

            'fusionar_contactos' => array(

                                        array(
                                                'field' => 'id_usuario_1',
                                                'label' => 'id_usuario_1',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_usuario_2',
                                                'label' => 'id_usuario_2',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_usuario',
                                                'label' => 'id_usuario',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                        array(
                                            'field' => 'nombre',
                                            'label' => 'nombre',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                        array(
                                            'field' => 'email[]',
                                            'label' => 'email[]',
                                            'rules' => 'trim|xss_clean'
                                        ),
                                        array(
                                            'field' => 'telefono[]',
                                            'label' => 'telefono[]',
                                            'rules' => 'trim|xss_clean'
                                        )
                                ),

                'alta_documento_contacto' => array(

                                        array(
                                                'field' => 'documento',
                                                'label' => 'documento',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_tipo_documento',
                                                'label' => 'id_tipo_documento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

                'modifica_documento_contacto' => array(

                                        array(
                                                'field' => 'documento',
                                                'label' => 'documento',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_tipo_documento',
                                                'label' => 'id_tipo_documento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            ),
                                        array(
                                                'field' => 'id_documento_crm',
                                                'label' => 'id_documento_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

                'baja_documento_contacto' => array(

                                        array(
                                                'field' => 'id_documento_crm',
                                                'label' => 'id_documento_crm',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),


                'vincular_contactos' => array(

                                        array(
                                                'field' => 'id_usuario_1',
                                                'label' => 'id_usuario_1',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_usuario_2',
                                                'label' => 'id_usuario_2',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

                'buscar_programas_consulta' => array(

                                        array(
                                                'field' => 'id_consulta',
                                                'label' => 'id_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

                'cambiar_consulta_pipeline' => array(

                                        array(
                                                'field' => 'id_consulta_prg[]',
                                                'label' => 'id_consulta_prg[]',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_estado',
                                                'label' => 'id_estado',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

                'ver_consulta' => array(

                                        array(
                                                'field' => 'id_consulta',
                                                'label' => 'id_consulta',
                                                'rules' => 'required|trim|xss_clean|numeric|callback_comprobar_consulta_existente_validation'
                                            )
                                ),


            'ver_enviar_email_masivo' => array(

                                        array(
                                                'field' => 'id_consulta[]',
                                                'label' => 'id_consulta[]',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            // Aca se valida el id consulta programa y no el de la consulta
            'ver_enviar_email_masivo_prg' => array(

                                        array(
                                                'field' => 'id_consulta_prg[]',
                                                'label' => 'id_consulta_prg[]',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),


            'sacar_consulta_standby' => array(

                                        array(
                                                'field' => 'id_consulta_prg[]',
                                                'label' => 'id_consulta_prg[]',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'alta_email_plantilla' => array(

                                        array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'asunto',
                                                'label' => 'asunto',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'texto',
                                                'label' => 'texto',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),


            'baja_email_plantilla' => array(

                                        array(
                                                'field' => 'id_crm_email_plantilla',
                                                'label' => 'id_crm_email_plantilla',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'modifica_email_plantilla' => array(

                                        array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'asunto',
                                                'label' => 'asunto',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'texto2',
                                                'label' => 'texto2',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_crm_email_plantilla',
                                                'label' => 'id_crm_email_plantilla',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'enviar_sigeu' => array(


                                    array(
                                                'field' => 'id_crm_persona',
                                                'label' => 'id_crm_persona',
                                                'rules' => 'required|trim|xss_clean|numeric|callback_comprobar_existe_id_sigeu'
                                    ),
                                     array(
                                                'field' => 'dni',
                                                'label' => 'dni',
                                                'rules' => 'callback_comprobar_existe_dni_sigeu'
                                    ),
                                ),

            'alta_evento' => array(

                                    array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                    ),
                                    array(
                                                'field' => 'id_tipo_evento',
                                                'label' => 'id_tipo_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    )
                                ),
            'modifica_evento' => array(

                                    array(
                                                'field' => 'id_crm_evento',
                                                'label' => 'id_crm_evento',
                                                'rules' => 'required|trim|xss_clean'
                                    ),
                                    array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                    ),
                                    array(
                                                'field' => 'id_tipo_evento',
                                                'label' => 'id_tipo_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    )
                                ),
            'baja_evento' => array(

                                    array(
                                                'field' => 'id_crm_evento',
                                                'label' => 'id_crm_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    )
                                ),

             'alta_asistente' => array(

                                    array(
                                                'field' => 'id_evento',
                                                'label' => 'id_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    ),
                                    array(
                                                'field' => 'id_crm_persona',
                                                'label' => 'id_crm_persona',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    )
                                ),

            'modificar_asistencia_evento' => array(

                                    array(
                                                'field' => 'id_crm_evento',
                                                'label' => 'id_crm_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    ),
                                    array(
                                                'field' => 'fecha',
                                                'label' => 'fecha',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    )
                                ),

            'modifica_datos_crm_persona' => array(

                                    array(
                                                'field' => 'id_crm_persona',
                                                'label' => 'id_crm_persona',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                    ),
                                    array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                    ) ,
                                    array(
                                                'field' => 'apellido',
                                                'label' => 'apellido',
                                                'rules' => 'required|trim|xss_clean'
                                    ),
                                    array(
                                                'field' => 'sexo',
                                                'label' => 'sexo',
                                                'rules' => 'required|trim|xss_clean'
                                    )
                                ),

            'alta_tipo_evento' => array(

                                        array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),


            'baja_tipo_evento' => array(

                                        array(
                                                'field' => 'id_tipo_evento',
                                                'label' => 'id_tipo_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'modifica_email_plantilla' => array(

                                        array(
                                                'field' => 'nombre',
                                                'label' => 'nombre',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_tipo_evento',
                                                'label' => 'id_tipo_evento',
                                                'rules' => 'required|trim|xss_clean|numeric'
                                            )
                                ),

            'eliminar_persona' => array(

                                        array(
                                                'field' => 'id_crm_persona',
                                                'label' => 'id_crm_persona',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),


            'procesa_cambiar_estado_cons_prg' => array(

                                        array(
                                                'field' => 'id_crm_consulta_prg',
                                                'label' => 'id_crm_consulta_prg',
                                                'rules' => 'required|trim|xss_clean'
                                            ),
                                        array(
                                                'field' => 'id_estado_cons_prg',
                                                'label' => 'id_estado_cons_prg',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'buscar_info_consulta_programa' => array(

                                        array(
                                                'field' => 'id_consulta_programa',
                                                'label' => 'id_consulta_programa',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'buscar_consulta' => array(

                                        array(
                                                'field' => 'fecha_desde',
                                                'label' => 'fecha_desde',
                                                'rules' => 'xss_clean'
                                            ),
                                        array(
                                                'field' => 'fecha_hasta',
                                                'label' => 'fecha_hasta',
                                                'rules' => 'xss_clean'
                                            ),
                                        array(
                                                'field' => 'programas_elegidos',
                                                'label' => 'programas_elegidos',
                                                'rules' => 'xss_clean'
                                            )

                                ),

             'alta_experiencia_laboral' => array(

                                        array(
                                                'field' => 'id_empresa',
                                                'label' => 'id_empresa',
                                                'rules' => 'xss_clean'
                                            )

                                ),
             
            'modifica_experiencia_laboral' => array(

                                        array(
                                                'field' => 'id_crm_persona_empresa',
                                                'label' => 'id_crm_persona_empresa',
                                                'rules' => 'required|xss_clean'
                                            )

                                ),


            'baja_experiencia_laboral' => array(

                                        array(
                                                'field' => 'id_crm_persona_empresa',
                                                'label' => 'id_crm_persona_empresa',
                                                'rules' => 'required|xss_clean'
                                            )

                                ),

            'enviar_email_masivo' => array(

                                        array(
                                                'field' => 'email[]',
                                                'label' => 'email[]',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'pre_importar_excel' => array(

                                        array(
                                                'field' => 'archivo',
                                                'label' => 'archivo',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'baja_asistente' => array(

                                        array(
                                                'field' => 'id_asistente_evento',
                                                'label' => 'id_asistente_evento',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),

            'existe_consulta_activa' => array(

                                        array(
                                                'field' => 'id',
                                                'label' => 'id',
                                                'rules' => 'required|trim|xss_clean'
                                            ),

                                        array(
                                                'field' => 'origen',
                                                'label' => 'origen',
                                                'rules' => 'required|trim|xss_clean'
                                            )
                                ),


            'alta_referente' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'nombre',
                                            'rules' => 'trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'apellido',
                                            'rules' => 'trim|xss_clean'
                                        )
                                ),
            'alta_empresa_referente' => array(
                                    array(
                                            'field' => 'id_empresa',
                                            'label' => 'id_empresa',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_crm_persona',
                                            'label' => 'id_crm_persona',
                                            'rules' => 'required|trim|xss_clean'
                                        )
                                ),
            'alta_accion_empresa' => array(
                                    array(
                                            'field' => 'id_empresa',
                                            'label' => 'id_empresa',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'fecha_accion',
                                            'label' => 'fecha_accion',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'descripcion',
                                            'label' => 'descripcion',
                                            'rules' => 'required|trim|xss_clean'
                                        )
                                ),

            'modifica_accion_empresa' => array(
                                    array(
                                            'field' => 'id_empresa',
                                            'label' => 'id_empresa',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'id_crm_accion',
                                            'label' => 'id_crm_accion',
                                            'rules' => 'required|trim|xss_clean'
                                        ),
                                    array(
                                            'field' => 'descripcion',
                                            'label' => 'descripcion',
                                            'rules' => 'required|trim|xss_clean'
                                        )
                                ),

            'baja_accion_empresa' => array(

                                    array(
                                            'field' => 'id_crm_accion',
                                            'label' => 'id_crm_accion',
                                            'rules' => 'required|trim|xss_clean'
                                        )

                                ),

            'ver_empresa' => array(
                                        array(
                                                'field' => 'id_empresa',
                                                'label' => 'id_empresa',
                                                'rules' => 'required|trim|xss_clean|numeric|callback_comprobar_empresa_crm_existente_validation'
                                            )
                                ),

              'alta_acuerdo_empresa' => array(
                                            array(
                                                    'field' => 'id_empresa',
                                                    'label' => 'id_empresa',
                                                    'rules' => 'required|trim|xss_clean|numeric|callback_comprobar_empresa_crm_existente_validation'
                                                ),
                                             array(
                                                    'field' => 'descripcion',
                                                    'label' => 'descripcion',
                                                    'rules' => 'required|trim|xss_clean'
                                                )
                                ),

              'modifica_acuerdo_empresa' => array(
                                            array(
                                                    'field' => 'id_crm_empresa_acuerdo',
                                                    'label' => 'id_crm_empresa_acuerdo',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                ),
                                             array(
                                                    'field' => 'descripcion',
                                                    'label' => 'descripcion',
                                                    'rules' => 'required|trim|xss_clean'
                                                )
                                ),
            
            'baja_acuerdo_empresa' => array(
                                            array(
                                                    'field' => 'id_crm_empresa_acuerdo',
                                                    'label' => 'id_crm_empresa_acuerdo',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                ) 
                                ),
        
            'alta_accion_resultado' => array(                                                                                                                                                                                                                                                               
                                             array(
                                                    'field' => 'descripcion_finalizar_alarma',
                                                    'label' => 'descripcion_finalizar_alarma',
                                                    'rules' => 'trim|xss_clean'
                                                ),
                                            array(
                                                    'field' => 'id_crm_persona',
                                                    'label' => 'id_crm_persona',
                                                    'rules' => 'trim|xss_clean|numeric'
                                                ),
                                            array(
                                                    'field' => 'id_crm_accion',
                                                    'label' => 'id_crm_accion',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                )

                                ),

            'existe_persona_empresa' => array(  
                
                                            array(
                                                    'field' => 'id_crm_persona',
                                                    'label' => 'id_crm_persona',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                ),
                                            array(
                                                    'field' => 'id_empresa',
                                                    'label' => 'id_empresa',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                )

                                ),

            'asignar_consulta' => array(  
                
                                            array(
                                                    'field' => 'id_persona',
                                                    'label' => 'id_persona',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                ),
                                            array(
                                                    'field' => 'id_consulta[]',
                                                    'label' => 'id_consulta[]',
                                                    'rules' => 'required|trim|xss_clean'
                                                )

                                ),
            
            'alta_alarma' => array(  
                
                                            array(
                                                    'field' => 'id_crm_consulta',
                                                    'label' => 'id_crm_consulta',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                ),
                                            array(
                                                    'field' => 'fecha_alarma',
                                                    'label' => 'fecha_alarma',
                                                    'rules' => 'required|trim|xss_clean'
                                                ),
                                            array(
                                                    'field' => 'descripcion',
                                                    'label' => 'descripcion',
                                                    'rules' => 'required|trim|xss_clean'
                                                )

                                ),
            
            'baja_alarma' => array(  
                
                                            array(
                                                    'field' => 'id_crm_consulta_alarma',
                                                    'label' => 'id_crm_consulta_alarma',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                )

                                ),
            
            'alta_camara' => array(  
                
                                            array(
                                                    'field' => 'nombre',
                                                    'label' => 'nombre',
                                                    'rules' => 'required|trim|xss_clean'
                                                )

                                ),

             'ver_camara' => array(
                                        array(
                                                'field' => 'id_camara',
                                                'label' => 'id_camara',
                                                'rules' => 'required|trim|xss_clean|numeric|callback_comprobar_camara_crm_existente_validation'
                                            )
                                ),

            
            'baja_empresa_referente' => array(  
                
                                            array(
                                                    'field' => 'id_crm_persona',
                                                    'label' => 'id_crm_persona',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                ),
                                            array(
                                                    'field' => 'id_empresa',
                                                    'label' => 'id_empresa',
                                                    'rules' => 'required|trim|xss_clean|numeric'
                                                )

                                ),
);
?>  