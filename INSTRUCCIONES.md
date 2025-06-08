### Instrucciones de intalación

Seguiremos los siguientes pasos para asegurarnos de la integridad de la BD.

**Migramos toda la BD**

```bash
php artisan migrate:fresh --seed
```

Si no existiera la BD, hacer:

### Ciclistas
```bash
touch database/database.sqlite
```

**Opción 1: Volcamos el backup de ciclistas del archivo csv**
Tenemos el archivo storage/app/exports/ciclistas.csv con todos los corredores.
Lanzamos un proceso para volcar los datos en la BD:
```bash
php artisan import:cyclists-from-csv
```
> Nota: para generar este archivo una vez sabemos que nuestra BD tiene los datos de Ciclistas correctamente debemos lanzar: **php artisan export:cyclists-to-csv**



**Opción 2: Cargamos el Seeder de Ciclistas**

Cargamos el Seeder, o bien el archivo .csv con todos los corredores.
Así cargamos el archivo: (temporada y nombre de archivo)
Si está dentro de la carpeta 4 (temporada 4) el archivo corredores.csv
```bash
php artisan import:corredores 4 corredores
php artisan import:corredores 5 draft-u24
php artisan import:corredores 5 t5-definitivo
```
y luego les corregimos los campos de los nombres y apellidos:
```bash
php artisan update:cyclist-names
```


Así cargamos el seeder:
```bash
php artisan db:seed --class=CiclistaSeeder
```

**Cargamos el Seeder de Carreras**
O si no lo tenemos, debemos crear los registros necesarios de una tempoarada.
En caso de tenerlos en el Seeder, como es nuestro caso, lo lanzamos. 

```bash
php artisan db:seed --class=CarreraSeeder
```

**Cargamos el Seeder de Etapa**
Una vez tenemos definidas las carreras que van a componer una temporada lanzamos este Seeder que generará las Etapas automáticamente.
Solo genera las etapas, pero habría que editar los perfiles etapa a etapa.

```bash
php artisan db:seed --class=EtapaSeeder
```

**Cargamos el Seeder de Favoritos de cada Etapa**

```bash
php artisan db:seed --class=FavoritosEtapaSeeder
```

>> **Cargamos el Seeder de Calendario**
Una vez tenemos definidas las carreras que van a componer una temporada lanzamos este Seeder que generará el Calendario automáticamente.
En este caso hemos hecho 2 procesos para la misma tarea. Elegimos cual de las 2 opciones nos gusta más.
>> 1. **Lanzar el proceso run()**. Previamente debemos modificar a mano el valor de la temporada que queremos procesar, especificada dentro del propio proceso como $temporada.

```bash
   php artisan db:seed --class=CalendarioSeeder
```
>>2. **Lanzar el proceso runWithTemporada() mediante tinker**.
```bash
   php artisan tinker
```

>> Y una vez dentro de tinker, nótese que le pasamos por parámetro la temporada que queremos generar. Es este caso la 4:
```bash
      $seeder = new Database\Seeders\CalendarioSeeder();
      $seeder->runWithTemporada(4);
```
**Lanzar el script que inserta en BD las puntuaciones especificadas en el puntos.json**

En el archivo puntos.json configuramos como se distribuyen las diferentes puntuaciones segun clasificaciones generales y provisionales.
El proceso recoge el número de temporada de tcm.temporada e insertará en la tabla Puntos todos los valores especificados en el json.
Así lanzamos el proceso:
```bash
php artisan populate:puntos-from-json
```

**Lanzar inscripciones a carreras, en caso de que las haya**

Los archivos de cada carrera se llamarán {num_carrera}.ins
El proceso se lanzará con el número de temporada como parámetro e irá procesando todos los archivos uno a uno, inscribiendo a todos los corredores en la tabla Resultados con la posicion = 0.
Así lanzamos el proceso (para la temporada 4):
```bash
php artisan import:inscripciones 4 
```
Así lanzamos el proceso (para la temporada 4 carrera 65):
```bash
php artisan import:inscripciones 4 65
```

**Generar una Start List (SL) a partir de los datos de la BD**

Previamente deberemos haber hecho las inscripciones. De esa forma se guardan en la BD. A partir de esos datos almacenados podemos generar el fichero con la start list que necesita el juego para el día de la restansmisión.
Aquí vemos un ejemplo para generar la SL de la carrera 33:
```bash
php artisan generate:startlist 5 33
```

**Actualizar la BD con las Excels de resultados**

Los archivos de entrada se almacenarán en app/imports/resultados/semana-XX. Serán archivos "XX descripcion Etapa Y.xlsx".
Aquí vemos un ejemplo para procesar uno de ellos:
```bash
php artisan process:race-results semana-21
```

**Procesar los archivos de Formas**

Los archivos de entrada se almacenarán en app/imports/resultados/semana-XX. Serán archivos "import Semama Forma XX.xlsx".
Aquí vemos un ejemplo para procesar uno de ellos:
```bash
php artisan process:forma-results 19 
```
