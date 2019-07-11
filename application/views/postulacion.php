<?php // Change the css classes to suit your needs

$attributes = array('class' => '', 'id' => '');
echo form_open('postulacion', $attributes); ?>

<p>
        <label for="id_persona">id persona <span class="required">*</span></label>
        <?php echo form_error('id_persona'); ?>
        <br /><input id="id_persona" type="text" name="id_persona"  value="<?php echo set_value('id_persona'); ?>"  />
</p>

<p>
        <label for="nombres">Nombres <span class="required">*</span></label>
        <?php echo form_error('nombres'); ?>
        <br /><input id="nombres" type="text" name="nombres"  value="<?php echo set_value('nombres'); ?>"  />
</p>

<p>
        <label for="apellidos">Apellidos <span class="required">*</span></label>
        <?php echo form_error('apellidos'); ?>
        <br /><input id="apellidos" type="text" name="apellidos"  value="<?php echo set_value('apellidos'); ?>"  />
</p>

<p>
        <label for="nombre">Nombre <span class="required">*</span></label>
        <?php echo form_error('nombre'); ?>
        <br /><input id="nombre" type="text" name="nombre" maxlength="255" value="<?php echo set_value('nombre'); ?>"  />
</p>

<p>
        <label for="email_ucema">Email UCEMA</label>
        <?php echo form_error('email_ucema'); ?>
        <br /><input id="email_ucema" type="text" name="email_ucema"  value="<?php echo set_value('email_ucema'); ?>"  />
</p>

<p>
        <label for="email_personal">Email Personal</label>
        <?php echo form_error('email_personal'); ?>
        <br /><input id="email_personal" type="text" name="email_personal"  value="<?php echo set_value('email_personal'); ?>"  />
</p>

<p>
        <label for="telefono_celular">Telefono Celular</label>
        <?php echo form_error('telefono_celular'); ?>
        <br /><input id="telefono_celular" type="text" name="telefono_celular"  value="<?php echo set_value('telefono_celular'); ?>"  />
</p>

<p>
        <label for="telefono_fijo">Telefono Fijo</label>
        <?php echo form_error('telefono_fijo'); ?>
        <br /><input id="telefono_fijo" type="text" name="telefono_fijo"  value="<?php echo set_value('telefono_fijo'); ?>"  />
</p>

<p>
        <label for="pais_de_nacimiento">Pais de Nacimiento</label>
        <?php echo form_error('pais_de_nacimiento'); ?>
        <br /><input id="pais_de_nacimiento" type="text" name="pais_de_nacimiento" maxlength="255" value="<?php echo set_value('pais_de_nacimiento'); ?>"  />
</p>

<p>
        <label for="nacionalidad_1">Nacionalidad 1 <span class="required">*</span></label>
        <?php echo form_error('nacionalidad_1'); ?>
        <br /><input id="nacionalidad_1" type="text" name="nacionalidad_1" maxlength="255" value="<?php echo set_value('nacionalidad_1'); ?>"  />
</p>

<p>
        <label for="numero_de_pasarporte_1">Numero de pasarporte 1 <span class="required">*</span></label>
        <?php echo form_error('numero_de_pasarporte_1'); ?>
        <br /><input id="numero_de_pasarporte_1" type="text" name="numero_de_pasarporte_1"  value="<?php echo set_value('numero_de_pasarporte_1'); ?>"  />
</p>

<p>
        <label for="archivo_pasaporte_1">Archivo Pasaporte 1 <span class="required">*</span></label>
        <?php echo form_error('archivo_pasaporte_1'); ?>
        <br /><input id="archivo_pasaporte_1" type="text" name="archivo_pasaporte_1"  value="<?php echo set_value('archivo_pasaporte_1'); ?>"  />
</p>

<p>
        <label for="nacionalidad_2">Nacionalidad 2</label>
        <?php echo form_error('nacionalidad_2'); ?>
        <br /><input id="nacionalidad_2" type="text" name="nacionalidad_2"  value="<?php echo set_value('nacionalidad_2'); ?>"  />
</p>

<p>
        <label for="numero_de_pasarporte_2">Numero de pasarporte 2</label>
        <?php echo form_error('numero_de_pasarporte_2'); ?>
        <br /><input id="numero_de_pasarporte_2" type="text" name="numero_de_pasarporte_2"  value="<?php echo set_value('numero_de_pasarporte_2'); ?>"  />
</p>

<p>
        <label for="archivo_pasaporte_2">Archivo Pasaporte 2</label>
        <?php echo form_error('archivo_pasaporte_2'); ?>
        <br /><input id="archivo_pasaporte_2" type="text" name="archivo_pasaporte_2"  value="<?php echo set_value('archivo_pasaporte_2'); ?>"  />
</p>

<p>
        <label for="fin_cursada">Fin cursada</label>
        <?php echo form_error('fin_cursada'); ?>
        <br /><input id="fin_cursada" type="text" name="fin_cursada"  value="<?php echo set_value('fin_cursada'); ?>"  />
</p>

<p>
        <label for="certificado_idioma_1">Certificado Idioma 1</label>
        <?php echo form_error('certificado_idioma_1'); ?>
        <br /><input id="certificado_idioma_1" type="text" name="certificado_idioma_1"  value="<?php echo set_value('certificado_idioma_1'); ?>"  />
</p>

<p>
        <label for="puntaje_certificado_1">Puntaje Certificado 1</label>
        <?php echo form_error('puntaje_certificado_1'); ?>
        <br /><input id="puntaje_certificado_1" type="text" name="puntaje_certificado_1"  value="<?php echo set_value('puntaje_certificado_1'); ?>"  />
</p>

<p>
        <label for="fecha_a_rendir_examen_1">Fecha a rendir</label>
        <?php echo form_error('fecha_a_rendir_examen_1'); ?>
        <br /><input id="fecha_a_rendir_examen_1" type="text" name="fecha_a_rendir_examen_1"  value="<?php echo set_value('fecha_a_rendir_examen_1'); ?>"  />
</p>


<p>
        <?php echo form_submit( 'submit', 'Submit'); ?>
</p>

<?php echo form_close(); ?>