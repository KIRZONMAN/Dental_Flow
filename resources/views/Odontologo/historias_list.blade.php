<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historia Clínica de {{ $paciente->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="p-5">

    <h1 class="mb-4">📝 Historia Clínica de {{ $paciente->nombre }}</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Antecedentes</th>
                <th>Tratamientos realizados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historias as $h)
                <tr id="fila-{{ $h->id_historia_clinica }}">
                    <td>{{ $h->antecedentes_medicos }}</td>
                    <td>{{ $h->tratamiento_realizados }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger btn-eliminar" data-id="{{ $h->id_historia_clinica }}">
                            🗑
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <a href="{{ route('odontologo.agenda') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver a Agenda
    </a>

    {{-- SweetAlert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                Swal.fire({
                    title: '¿Eliminar esta historia?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, bórrala',
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
                        .then(r => r.ok ? r.json() : r.json().then(e => Promise.reject(e)))
                        .then(() => {
                            document.getElementById(`fila-${id}`).remove();
                            Swal.fire('Eliminada', '', 'success');
                        })
                        .catch(e => {
                            Swal.fire('Error', e.error || e.message, 'error');
                        });
                });
            });
        });
    </script>

</body>

</html>
