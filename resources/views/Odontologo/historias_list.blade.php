<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historia Clínica de {{ $paciente->nombre }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">

        <h1 class="mb-4">📝 Historia Clínica de {{ $paciente->nombre }}</h1>

        <div class="table-responsive mb-4">
            <table class="table table-striped table-hover align-middle shadow-sm bg-white rounded">
                <thead class="table-dark">
                    <tr>
                        <th>Antecedentes</th>
                        <th>Tratamientos realizados</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historias as $h)
                        <tr id="fila-{{ $h->id_historia_clinica }}">
                            <td>{{ $h->antecedentes_medicos }}</td>
                            <td>{{ $h->tratamiento_realizados }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger btn-eliminar"
                                    data-id="{{ $h->id_historia_clinica }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                No hay historias registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('odontologo.agenda') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Agenda
        </a>

    </div>

    <!-- SweetAlert2 & Bootstrap JS -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                Swal.fire({
                    title: '¿Eliminar esta historia?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, bórrala',
                    cancelButtonText: 'Cancelar'
                }).then(({
                    isConfirmed
                }) => {
                    if (!isConfirmed) return;
                    fetch(`/odontologo/historias/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.ok ? res.json() : Promise.reject())
                        .then(() => {
                            document.getElementById(`fila-${id}`).remove();
                            Swal.fire('Eliminada', '', 'success');
                        })
                        .catch(() => {
                            Swal.fire('Error', 'No se pudo eliminar la historia.', 'error');
                        });
                });
            });
        });
    </script>
</body>

</html>
