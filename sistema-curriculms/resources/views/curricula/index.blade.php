<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Currículums</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-list"></i> Lista de Currículums</h2>
            <a href="{{ route('curricula.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Currículum
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Fotografía</th>
                                <th>Nombre Completo</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Nota Media</th>
                                <th>Edad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($curricula as $curriculum)
                                <tr>
                                    <td>
                                        @if($curriculum->fotografia)
                                            <img src="{{ asset('storage/' . $curriculum->fotografia) }}" 
                                                 class="rounded-circle" 
                                                 width="50" 
                                                 height="50"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $curriculum->nombre_completo }}</td>
                                    <td><i class="fas fa-envelope text-primary"></i> {{ $curriculum->correo }}</td>
                                    <td><i class="fas fa-phone text-success"></i> {{ $curriculum->telefono }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($curriculum->nota_media, 2) }}</span>
                                    </td>
                                    <td>{{ $curriculum->edad }} años</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('curricula.show', $curriculum) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('curricula.edit', $curriculum) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('curricula.destroy', $curriculum) }}" 
                                                  method="POST" 
                                                  style="display:inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este currículum?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        No hay currículums registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            {{ $curricula->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>