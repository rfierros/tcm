### Instrucciones de intalación

Seguiremos los siguientes pasos para asegurarnos de la integridad de la BD.

**Migramos toda la BD**

```php
php artisan migrate:fresh --seed
```

**Cargamos el Seeder de Ciclistas**

Cargamos el Seeder, o bien el archivo .csv con todos los corredores.
Así cargamos el archivo:
```php
php artisan import:corredores
```

Así cargamos el seeder:
```php
php artisan db:seed --class=CiclistaSeeder
```

**Cargamos el Seeder de Carreras**
O si no lo tenemos, debemos crear los registros necesarios de una tempoarada.
En caso de tenerlos en el Seeder, como es nuestro caso, lo lanzamos. 

```php
php artisan db:seed --class=CarreraSeeder
```

**Cargamos el Seeder de Etapa**
Una vez tenemos definidas las carreras que van a componer una temporada lanzamos este Seeder que generará las Etapas automáticamente.
Solo genera las etapas, pero habría que editar los perfiles etapa a etapa.

```php
   php artisan db:seed --class=EtapaSeeder
```

**Cargamos el Seeder de Calendario**
Una vez tenemos definidas las carreras que van a componer una temporada lanzamos este Seeder que generará el Calendario automáticamente.
En este caso hemos hecho 2 procesos para la misma tarea. Elegimos cual de las 2 opciones nos gusta más.

1. **Lanzar el proceso run()**. Perviamente debemos modificar a mano el valor de la temporada que queremos procesar, especificada dentro del propio proceso como $temporada.
```php
   php artisan db:seed --class=CalendarioSeeder
```

2. **Lanzar el proceso runWithTemporada() mediante tinker**.
```php
   php artisan tinker
```

Y una vez dentro de tinker, nótese que le pasamos por parámetro la temporada que queremos generar. Es este caso la 4:
```php
      $seeder = new Database\Seeders\CalendarioSeeder();
      $seeder->runWithTemporada(4);
```
