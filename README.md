# Configuración de entorno para CRM

**Configurar DB Oracle (drivers, OCI8):**
(https://alum.ucema.edu.ar/wiki/doku.php?id=dptosistemas:crm-config&s[]=crm)


##Setup en localhost:

* Crear en /etc/apache2/sites-available un archivo crm.conf con lo siguiente:

```
<VirtualHost *:80>
  DocumentRoot /path/to/crm
  ServerName crm
  DirectoryIndex index.php
  ErrorLog "/var/log/apache2/crm-error_log"
  CustomLog "/var/log/apache2/crm-access_log" common
  Alias /app/ /path/to/crm/
    <Directory /path/to/crm/>
        AllowOverride All
        Allow from All
        Require all granted
        FallbackResource /index.php
    </Directory>
</VirtualHost>
```

* Crear archivos de logs:

```
touch /var/log/apache2/crm-error_log
touch /var/log/apache2/crm-access_log
```

* Habilitar la configuración del sitio:

```
cd /etc/apache2/sites-available
a2ensite crm.conf
```

* Modificar archivo /etc/hosts en la línea de localhost:

```
127.0.0.1	localhost crm
```

* Reiniciar apache:

```
sudo service apache2 restart
```

* Crear un archivo de configuración base_url (en el root del proyecto) con el base_url:

```
echo http://crm/ > base_url
```

* Ingresar en http://crm/ y probar loguearse
