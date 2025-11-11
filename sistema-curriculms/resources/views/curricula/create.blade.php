<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Currículum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="fas fa-file-alt"></i> Sistema de Gestión de Currículums
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Registrar Nuevo Currículum</h4>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Por favor corrige los siguientes errores:</h6>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('curricula.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user"></i> Datos Personales</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                    <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nota Media (0-10) <span class="text-danger">*</span></label>
                                    <input type="number" name="nota_media" class="form-control" step="0.01" min="0" max="10" value="{{ old('nota_media') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fotografía</label>
                                <input type="file" name="fotografia" class="form-control" accept="image/*">
                                <small class="text-muted">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</small>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4"><i class="fas fa-briefcase"></i> Información Profesional</h5>

                            <div class="mb-3">
                                <label class="form-label">Experiencia Laboral <span class="text-danger">*</span></label>
                                <textarea name="experiencia" class="form-control" rows="4" required>{{ old('experiencia') }}</textarea>
                                <small class="text-muted">Describe tus experiencias laborales anteriores</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Formación Académica <span class="text-danger">*</span></label>
                                <textarea name="formacion" class="form-control" rows="4" required>{{ old('formacion') }}</textarea>
                                <small class="text-muted">Indica tus estudios, títulos y certificaciones</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Habilidades <span class="text-danger">*</span></label>
                                <textarea name="habilidades" class="form-control" rows="3" required>{{ old('habilidades') }}</textarea>
                                <small class="text-muted">Lista tus habilidades técnicas y personales</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('curricula.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Guardar Currículum
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>