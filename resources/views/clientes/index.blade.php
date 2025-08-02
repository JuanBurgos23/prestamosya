@extends('adminlte::page')

@section('title', 'Gestión de Clientes')
@section('content_header')
    <h1></h1>
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('css/clientes-lista.css') }}">

<div class="container">
    <header class="page-header">
        <div class="logo">
            <i class="fas fa-building"></i>
            <span>Préstamos Ya</span>
        </div>
        <h1>Gestión de Clientes</h1>
        <div class="header-actions">
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Cliente
            </a>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Buscar clientes...">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </header>

    <div class="client-controls">
        <div class="filter-section">
            <label for="filterStatus">Filtrar por:</label>
            <select id="filterStatus" class="filter-select">
                <option value="all">Todos los clientes</option>
                <option value="active">Activos</option>
                <option value="inactive">Inactivos</option>
            </select>
            
            <label for="sortBy">Ordenar por:</label>
            <select id="sortBy" class="filter-select">
                <option value="name-asc">Nombre (A-Z)</option>
                <option value="name-desc">Nombre (Z-A)</option>
                <option value="date-desc">Más recientes</option>
                <option value="date-asc">Más antiguos</option>
            </select>
        </div>

        <div class="stats-section">
            <div class="stat-card">
                <span class="stat-value">{{ count($clientes) }}</span>
                <span class="stat-label">Clientes totales</span>
            </div>
            <!-- Puedes agregar más estadísticas si lo deseas -->
        </div>
    </div>

    <div class="client-table-container">
        <table class="client-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>CI</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre_completo }}</td>
                        <td>{{ $cliente->ci }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-info">Editar</a>
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar cliente?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- paginación opcional --}}
        {{-- {{ $clientes->links() }} --}}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/clientes-lista.js') }}"></script>
@endsection
