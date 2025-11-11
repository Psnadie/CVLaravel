<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Currículum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px 10px 0 0;
        }
        .section-title {
            border-left: 4px solid #667eea;
            padding-left: 15px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="fas fa-file-alt"></i> Sistema de Gestión de Currículums
            </span>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="profile-header text-center">
                        @if($curriculum->fotografia)
                            <img src="{{ asset('storage/' . $curriculum->fotografia) }}" 
                                 class="rounded-circle border border-4 border-white mb-3" 
                                 width="150" 
                                 height="150"
                                 style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center mb-3" 
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-4x"></i>
                            </div>
                        @endif
                        <h2 class="mb-1">{{ $curriculum->nombre_completo }}</h2>
                        <p class="mb-0"><i class="fas fa-birthday-cake"></i> {{ $curriculum->edad }} años</p>
                    </div>

                    <div class="card-body p-4">
                        <!-- Información de Contacto -->
                        <h4 class="section-title"><i class="fas fa-address-card"></i> Información de Contacto</h4>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-envelope text-primary"></i> Correo:</strong><br>
                                {{ $curriculum->correo }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-phone text-success"></i> Teléfono:</strong><br>
                                {{ $curriculum->telefono }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-calendar text-info"></i> Fecha de Nacimiento:</strong><br>
                                {{ $curriculum->fecha_nacimiento->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                php                                <p><strong><i class="fas fa-graduation-cap text-warning"></i> Nota Media:</strong><br>
                                <span class="badge bg-info fs-6">{{ number_format($curriculum->nota_media, 2) }}/10</span></p>
                            </div>
                        </div>

                        <!-- Experiencia Laboral -->
                        <h4 class="section-title"><i class="fas fa-briefcase"></i> Experiencia Laboral</h4>
                        <div class="bg-light p-3 rounded mb-3">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $curriculum->experiencia }}</p>
                        </div>

                        <!-- Formación Académica -->
                        <h4 class="section-title"><i class="fas fa-university"></i> Formación Académica</h4>
                        <div class="bg-light p-3 rounded mb-3">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $curriculum->formacion }}</p>
                        </div>

                        <!-- Habilidades -->
                        <h4 class="section-title"><i class="fas fa-tools"></i> Habilidades</h4>
                        <div class="bg-light p-3 rounded mb-3">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $curriculum->habilidades }}</p>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="border-top pt-3 mt-4">
                            <p class="text-muted small mb-0">
                                <i class="fas fa-clock"></i> <strong>Registrado:</strong> {{ $curriculum->created_at->format('d/m/Y H:i') }}
                                @if($curriculum->updated_at != $curriculum->created_at)
                                    | <strong>Última actualización:</strong> {{ $curriculum->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </p>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('curricula.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver al Listado
                            </a>
                            <div>
                                <a href="{{ route('curricula.edit', $curriculum) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('curricula.destroy', $curriculum) }}" 
                                      method="POST" 
                                      style="display:inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este currículum?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>