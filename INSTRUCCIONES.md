### Instrucciones de intalación

Seguiremos los siguientes pasos para asegurarnos de la integridad de la BD.

**Migramos toda la BD**

```php
php artisan migrate:fresh --seed
```

### Ciclistas

**Opción 1: Volcamos el backup de ciclistas del archivo csv**
Tenemos el archivo storage/app/exports/ciclistas.csv con todos los corredores.
Lanzamos un proceso para volcar los datos en la BD:
```php
php artisan import:cyclists-from-csv
```
> Nota: para generar este archivo una vez sabemos que nuestra BD tiene los datos de Ciclistas correctamente debemos lanzar: **php artisan export:cyclists-to-csv**



**Opción 2: Cargamos el Seeder de Ciclistas**

Cargamos el Seeder, o bien el archivo .csv con todos los corredores.
Así cargamos el archivo:
```php
php artisan import:corredores
```
y luego les corregimos los campos de los nombres y apellidos:
```php
php artisan update:cyclist-names
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
**Lanzar el script que inserta en BD las puntuaciones especificadas en el puntos.json**

En el archivo puntos.json configuramos como se distribuyen las diferentes puntuaciones segun clasificaciones generales y provisionales.
El proceso recoge el número de temporada de tcm.temporada e insertará en la tabla Puntos todos los valores especificados en el json.
Así lanzamos el proceso:
```php
php artisan populate:puntos-from-json
```

**Lanzar inscripciones a carreras, en caso de que las haya**

Los archivos de cada carrera se llamarán {carrera_id}.ins
El proceso se lanzará con el número de temporada como parámetro e irá procesando todos los archivos uno a uno, inscribiendo a todos los corredores en la tabla Resultados con la posicion = 0.
Así lanzamos el proceso (para la temporada 4):
```php
php artisan import:inscripciones 4
```

**Generar una Start List (SL) a partir de los datos de la BD**

Previamente deberemos haber hecho las inscripciones. De esa forma se guardan en la BD. A partir de esos datos almacenados podemos generar el fichero con la start list que necesita el juego para el día de la restansmisión.
Aquí vemos un ejemplo para generar la SL de la carrera 33:
```php
php artisan generate:startlist 33
```

**Actualizar la BD con las Excels de resultados**

Los archivos se almacenarán en app/imports/resultados. Serán archivos .xlsx y la nomenclatura de los mismos deberá ser empezar por el num_carrera de esa competición, y acabar con "Etapa x" donde x es el número de la etapa. Todo el texto que tengamos en medio será meramente informativo y a nosotros no nos afecta.
El proceso se lanzará con el nombre exacto del archivo que queremos procesar.
Aquí vemos un ejemplo para la Etapa 3 de la carrera 9.:
```php
php artisan process:race-results "09 Tour des Alpes-Maritimes Etapa 3.xlsx"
```
