# Sistema de Gestión de Currículums - Laravel

## Descripción del Proyecto

Aplicación web desarrollada en Laravel para la gestión completa de currículums vitae. Permite crear, visualizar, editar y eliminar currículums, incluyendo la subida de fotografías.

## Características

- CRUD completo (Create, Read, Update, Delete)
- Las 7 rutas estándar
- Subida y gestión de fotografías
- Validación de datos del lado del servidor
- Cálculo automático de edad
- Interfaz responsive con Bootstrap 5
- Mensajes de confirmación y alertas
- Paginación de resultados
- Diseño moderno con iconos Font Awesome

---

## Instalación

### 1. Requisitos Previos

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Servidor web (Apache/Nginx)

### 2. Crear el Proyecto

```bash
composer create-project laravel/laravel sistema-curriculums
cd sistema-curriculums
```

### 3. Configurar Base de Datos

Editar el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bbddCV
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generar Recursos

```bash
php artisan make:model Curriculum -mcr
```

Este comando crea lo siguiente:
- Modelo: `app/Models/Curriculum.php`
- Migración: `database/migrations/xxxx_create_curricula_table.php`
- Controlador: `app/Http/Controllers/CurriculumController.php`

Lo que nos ahorra el tener que hacer cada comando individual como:
```bash
php artisan make:model Curriculum
php artisan make:controller controllerCurriculum
php artisan make:migration Curriculum
```

---

## Estructura de la Base de Datos

### Tabla: `curricula`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT (PK) | Identificador único |
| nombre | VARCHAR(255) | Nombre de la persona |
| apellidos | VARCHAR(255) | Apellidos |
| telefono | VARCHAR(20) | Número de teléfono |
| correo | VARCHAR(255) UNIQUE | Correo electrónico |
| fecha_nacimiento | DATE | Fecha de nacimiento |
| nota_media | DECIMAL(4,2) | Nota media académica (0-10) |
| experiencia | TEXT | Experiencia laboral |
| formacion | TEXT | Formación académica |
| habilidades | TEXT | Habilidades técnicas y personales |
| fotografia | VARCHAR(255) | Ruta de la foto de perfil |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de última actualización |

### Migración

```php
Schema::create('curricula', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('apellidos');
    $table->string('telefono');
    $table->string('correo')->unique();
    $table->date('fecha_nacimiento');
    $table->decimal('nota_media', 4, 2);
    $table->text('experiencia');
    $table->text('formacion');
    $table->text('habilidades');
    $table->string('fotografia')->nullable();
    $table->timestamps();
});
```

### Ejecutar Migración

```bash
php artisan migrate
```

---

## Modelo

### Archivo: `app/Models/Curriculum.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curricula';

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'correo',
        'fecha_nacimiento',
        'nota_media',
        'experiencia',
        'formacion',
        'habilidades',
        'fotografia'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'nota_media' => 'decimal:2'
    ];

    // Accesor para nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }

    // Accesor para calcular edad
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }
}
```

---

## Controlador

### Archivo: `app/Http/Controllers/CurriculumController.php`

Contiene las 7 acciones RESTful:

1. **index()** - Lista todos los currículums
2. **create()** - Muestra formulario de creación
3. **store()** - Guarda nuevo currículum
4. **show()** - Muestra un currículum específico
5. **edit()** - Muestra formulario de edición
6. **update()** - Actualiza un currículum
7. **destroy()** - Elimina un currículum

### Validaciones Implementadas

```php
$validated = $request->validate([
    'nombre' => 'required|string|max:255',
    'apellidos' => 'required|string|max:255',
    'telefono' => 'required|string|max:20',
    'correo' => 'required|email|unique:curricula,correo',
    'fecha_nacimiento' => 'required|date|before:today',
    'nota_media' => 'required|numeric|min:0|max:10',
    'experiencia' => 'required|string',
    'formacion' => 'required|string',
    'habilidades' => 'required|string',
    'fotografia' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
]);
```

### Gestión de Fotografías

**Subir fotografía:**
```php
if ($request->hasFile('fotografia')) {
    $validated['fotografia'] = $request->file('fotografia')->store('fotografias', 'public');
}
```

**Eliminar fotografía al actualizar:**
```php
if ($curriculum->fotografia) {
    Storage::disk('public')->delete($curriculum->fotografia);
}
```

---

## Rutas

### Archivo: `routes/web.php`

```php
use App\Http\Controllers\CurriculumController;

Route::get('/', function () {
    return redirect()->route('curricula.index');
});

Route::resource('curricula', CurriculumController::class);
```

### Rutas Generadas Automáticamente

| Método HTTP | URI | Nombre | Acción |
|-------------|-----|--------|--------|
| GET | /curricula | curricula.index | index() |
| GET | /curricula/create | curricula.create | create() |
| POST | /curricula | curricula.store | store() |
| GET | /curricula/{id} | curricula.show | show() |
| GET | /curricula/{id}/edit | curricula.edit | edit() |
| PUT/PATCH | /curricula/{id} | curricula.update | update() |
| DELETE | /curricula/{id} | curricula.destroy | destroy() |

---

## Vistas

### Estructura de Carpetas

```
resources/views/
└── curricula/
    ├── index.blade.php    # Listado de currículums
    ├── create.blade.php   # Formulario de creación
    ├── edit.blade.php     # Formulario de edición
    └── show.blade.php     # Vista detallada
```

### Tecnologías Frontend

- **Bootstrap 5.3.0** - Framework CSS
- **Font Awesome 6.4.0** - Iconos
- **HTML5** - Estructura
- **JavaScript** - Interactividad

---

## Almacenamiento de Archivos

### Crear Enlace Simbólico

Para que las fotografías sean accesibles públicamente:

```bash
php artisan storage:link
```

Este comando crea un enlace simbólico desde `public/storage` hacia `storage/app/public`.

### Mostrar Fotografías en Vistas

```php
@if($curriculum->fotografia)
    <img src="{{ asset('storage/' . $curriculum->fotografia) }}" alt="Foto">
@endif
```

---

## Funcionalidades por Vista

### 1. Index (Listado)

- Tabla con todos los currículums
- Fotografía miniatura o icono placeholder
- Información resumida (nombre, correo, teléfono, nota, edad)
- Botones de acción (Ver, Editar, Eliminar)
- Paginación (10 registros por página)
- Mensajes de éxito/error

### 2. Create (Crear)

- Formulario con todos los campos
- Validación en tiempo real
- Campos obligatorios marcados con asterisco
- Subida de fotografía opcional
- Mensajes de error detallados

### 3. Show (Ver)

- Diseño tipo CV profesional
- Header con gradiente y foto de perfil
- Secciones organizadas (contacto, experiencia, formación, habilidades)
- Información de timestamps
- Botones para editar y eliminar

### 4. Edit (Editar)

- Formulario precargado con datos existentes
- Previsualización de fotografía actual
- Opción de mantener o cambiar fotografía
- Validación con correo único (excepto el propio)

---

## Uso de la Aplicación

### Iniciar Servidor de Desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

### Crear un Currículum

1. Acceder a la página principal
2. Clic en "Nuevo Currículum"
3. Rellenar todos los campos obligatorios
4. Opcionalmente subir una fotografía
5. Clic en "Guardar Currículum"

### Ver Currículum

1. En el listado, clic en el icono del ojo (azul)
2. Se mostrará toda la información en formato profesional

### Editar Currículum

1. Clic en el icono de editar (amarillo)
2. Modificar los campos deseados
3. Clic en "Actualizar Currículum"

### Eliminar Currículum

1. Clic en el icono de eliminar (rojo)
2. Confirmar la acción
3. El currículum y su fotografía serán eliminados

---

## Datos de Prueba

### Usando Tinker

```bash
php artisan tinker
```

```php
\App\Models\Curriculum::create([
    'nombre' => 'Juan',
    'apellidos' => 'Pérez García',
    'telefono' => '123456789',
    'correo' => 'juan@ejemplo.com',
    'fecha_nacimiento' => '1995-05-15',
    'nota_media' => 8.5,
    'experiencia' => 'Desarrollador web en Empresa X (2020-2023)\nDesarrollador junior en Empresa Y (2018-2020)',
    'formacion' => 'Grado en Ingeniería Informática - Universidad Complutense de Madrid (2014-2018)',
    'habilidades' => 'PHP, Laravel, JavaScript, Vue.js, MySQL, Git, Docker'
]);
```

---

## Comandos Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Verificar migraciones
php artisan migrate:status

# Revertir última migración
php artisan migrate:rollback

# Refrescar base de datos (¡CUIDADO! Borra todos los datos)
php artisan migrate:fresh
```

---

## Seguridad

### Validaciones Implementadas

- ✅ Correo electrónico único
- ✅ Formato de email válido
- ✅ Fecha de nacimiento anterior a hoy
- ✅ Nota media entre 0 y 10
- ✅ Tipos de archivo de imagen permitidos (JPEG, PNG, JPG)
- ✅ Tamaño máximo de imagen: 2MB
- ✅ Protección CSRF en formularios
- ✅ Sanitización de entradas

### Recomendaciones Adicionales

- Implementar autenticación para proteger las rutas
- Añadir autorización por roles
- Implementar rate limiting
- Validar y sanitizar archivos subidos
- Usar HTTPS en producción

---

## Posibles Mejoras

1. **Autenticación de usuarios**
   - Laravel Breeze o Jetstream
   - Cada usuario gestiona solo sus currículums

2. **Búsqueda y filtros**
   - Por nombre, correo, nota media
   - Rango de fechas de nacimiento

3. **Exportación**
   - Generar PDF del currículum
   - Exportar a Word

4. **Soft Deletes**
   - Recuperar currículums eliminados
   - Papelera de reciclaje

5. **Multiidioma**
   - Soporte para varios idiomas
   - Traducciones de la interfaz

6. **API RESTful**
   - Endpoints JSON
   - Integración con aplicaciones móviles

7. **Dashboard con estadísticas**
   - Gráficos de notas medias
   - Distribución por edades
   - Habilidades más demandadas

8. **Notificaciones**
   - Email al crear currículum
   - Recordatorios de actualización

---

## Resolución de Problemas

### Error: "Class 'Curriculum' not found"

```bash
composer dump-autoload
```

### Las imágenes no se muestran

```bash
php artisan storage:link
```

Verificar permisos en `storage/app/public`:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Error de migración

```bash
php artisan migrate:fresh
```

---

## Estructura Final del Proyecto

```
sistema-curriculums/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── CurriculumController.php
│   └── Models/
│       └── Curriculum.php
├── database/
│   └── migrations/
│       └── xxxx_create_curricula_table.php
├── public/
│   └── storage/          # Enlace simbólico
│       └── fotografias/
├── resources/
│   └── views/
│       └── curricula/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
├── routes/
│   └── web.php
├── storage/
│   └── app/
│       └── public/
│           └── fotografias/
└── .env
```

---

## Conclusión

Este sistema de gestión de currículums implementa todas las operaciones CRUD básicas siguiendo las mejores prácticas de Laravel. Es una aplicación funcional, escalable y lista para ser desplegada o ampliada según las necesidades del proyecto.

## Créditos

- **Framework:** Laravel 10.x
- **Frontend:** Bootstrap 5.3.0
- **Iconos:** Font Awesome 6.4.0
- **Desarrollado para:** Proyecto educativo de CRUD con Laravel

---

**Fecha de documentación:** Noviembre 2025  
**Versión:** 1.0