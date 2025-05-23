@extends('layouts.app')

@section('title', 'Detalle de Orden #' . $orden->id_orden_lab)


@section('content')
<div class="container mt-4">
    <h2>Orden de Laboratorio #{{ $orden->id_orden_lab }}</h2>
    <hr>

    {{-- 1) Datos de la cita y paciente --}}
    <div class="mb-3">
        <h5>📋 Datos de la Cita</h5>
        <p><strong>Cita ID:</strong> {{ $orden->cita->id_cita }}</p>
        <p><strong>Fecha:</strong> {{ $orden->cita->fecha_cita->format('d/m/Y') }} a las
            {{ substr($orden->cita->hora_cita, 0, 5) }}</p>
        <p><strong>Paciente:</strong> {{ $orden->cita->paciente->nombre_completo_paciente }}</p>
    </div>

    {{-- 2) Datos del odontólogo --}}
    <div class="mb-3">
        <h5>🦷 Odontólogo</h5>
        <p>{{ optional($orden->cita->odontologo)->nombres_usuario }}
            {{ optional($orden->cita->odontologo)->apellidos_usuario }}</p>
    </div>

    {{-- 3) Detalles de la orden enviada --}}
    <div class="mb-3">
        <h5>📦 Detalles de la Solicitud</h5>
        <p><strong>Fecha de Solicitud:</strong> {{ $orden->fecha_solicitud->format('d/m/Y') }}</p>
        <p><strong>Fecha Límite:</strong> {{ $orden->fecha_limite->format('d/m/Y') }}</p>
        <p><strong>Horario:</strong> {{ ucfirst($orden->horario) }}</p>
        <p><strong>Tipo de Material:</strong> {{ $orden->tipo_material }}</p>
        <p><strong>Otros Detalles:</strong> {{ $orden->otros_detalles ?? '—' }}</p>
        <p><strong>Color:</strong> {{ $orden->color ?? '—' }}</p>
        @if ($orden->firma)
        <p><strong>Firma:</strong><br>
            <img src="{{ asset('storage/' . $orden->firma) }}" alt="Firma autorizada" style="max-width:200px;">
        </p>
        @endif
    </div>

    {{-- 4) Productos ya agregados (si los hay) --}}
    @if ($orden->productos->isNotEmpty())
    <div class="mb-3">
        <h5>🔧 Productos / Insumos asociados</h5>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Insumo</th>
                    <th>Cantidad</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orden->productos as $prod)
                <tr>
                    <td>{{ $prod->insumo->nombre_insumo }}</td>
                    <td>{{ $prod->cantidad }}</td>
                    <td>{{ $prod->detalles }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- 5) Formulario para actualizar estado --}}
    <div class="mb-4">
        <h5>⚙️ Actualizar Estado</h5>
        <form method="POST" action="{{ route('laboratorista.orden.estado', $orden->id_orden_lab) }}">
            @csrf
            <div class="input-group w-50">
                <select name="estado" class="form-select" required>
                    @foreach (['pendiente', 'en producción', 'listo para enviar', 'entregada', 'rechazada'] as $st)
                    <option value="{{ $st }}" {{ $orden->estado === $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                    @endforeach
                </select>
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
            @if (session('success'))
            <div class="mt-2 alert alert-success">{{ session('success') }}</div>
            @endif
        </form>
    </div>

    <a href="{{ route('laboratorista.ordenes.todos') }}" class="btn btn-secondary">
        ← Volver a Pedidos
    </a>
</div>
@endsection