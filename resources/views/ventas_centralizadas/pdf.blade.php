<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas Centralizadas por Curso</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            font-size: 11px; 
            color: #2c3e50; 
            margin: 40px; 
        }
        header { 
            text-align: center; 
            margin-bottom: 10px; 
        }
        .logo img { 
            width: 100px; 
        }
        h2 { 
            font-size: 20px; 
            margin: 10px 0 0; 
            color: #0a3d62; 
        }
        .sub { 
            font-size: 13px; 
            color: #555; 
        }
        
        /* Estadísticas */
        .stats-container {
            margin: 20px 0;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        .stat-card {
            border: 2px solid #0a3d62;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: #f8f9fa;
        }
        .stat-title {
            font-size: 10px;
            color: #0a3d62;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        th { 
            background-color: #0a3d62; 
            color: white; 
            padding: 8px 4px; 
            font-size: 9px;
            text-align: center;
            font-weight: bold;
        }
        td { 
            border: 1px solid #ccc; 
            padding: 6px 4px; 
            font-size: 9px; 
            text-align: center; 
        }
        
        /* Estilos específicos para columnas */
        .empresa-col {
            text-align: left;
            font-weight: bold;
            background-color: #f8f9fa;
            max-width: 80px;
        }
        .curso-col {
            text-align: left;
            font-weight: bold;
            color: #0a3d62;
            max-width: 100px;
        }
        .numero-col {
            background-color: #e3f2fd;
            font-weight: bold;
        }
        .banco-col {
            background-color: #f1f8ff;
            min-width: 30px;
        }
        .banco-count {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
            min-width: 18px;
        }
        .banco-count.zero {
            background-color: #6c757d;
        }
        .money {
            font-weight: bold;
            color: #28a745;
        }
        
        /* Fila de totales */
        .total-row {
            background-color: #0a3d62;
            color: white;
            font-weight: bold;
        }
        .total-row td {
            border-color: #2c3e50;
            font-size: 9px;
        }
        
        /* Resumen de bancos */
        .resumen-bancos {
            margin-top: 25px;
            border: 2px solid #0a3d62;
            border-radius: 8px;
            padding: 15px;
            background-color: #f8f9fa;
        }
        .resumen-title {
            font-size: 14px;
            color: #0a3d62;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }
        .bancos-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .banco-item {
            background: white;
            padding: 8px;
            border-radius: 5px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        .banco-name {
            font-weight: bold;
            color: #0a3d62;
            font-size: 10px;
        }
        .banco-total {
            font-size: 14px;
            font-weight: bold;
            color: #28a745;
        }
        
        .footer { 
            margin-top: 30px; 
            font-size: 10px; 
            text-align: right; 
            color: #888; 
        }
        
        /* Responsive adjustments */
        @media print {
            body { 
                margin: 20px; 
                print-color-adjust: exact; 
            }
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ public_path('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 200px; margin-bottom: 10px;">
    <h2 style="margin: 0; font-size: 22px; font-weight: bold;">CENTRO NACIONAL DE FORMACIÓN CONTINUA - BOLIVIA</h2>
    <h3 style="margin: 5px 0; font-size: 18px; color: #2c3e50;">REPORTE DE VENTAS CENTRALIZADAS POR CURSO</h3>
    <hr style="border-top: 2px solid #000; margin-top: 15px;">
</div>

<!-- Estadísticas Generales -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-title">TOTAL CURSOS</div>
        <div class="stat-value">{{ number_format($totales['total_cursos']) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">TOTAL INSCRITOS</div>
        <div class="stat-value">{{ number_format($totales['total_inscritos']) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">VENTAS TOTALES</div>
        <div class="stat-value">Bs {{ number_format($totales['total_ventas_curso'], 2) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-title">PAGOS CD</div>
        <div class="stat-value">Bs {{ number_format($totales['total_pagos_cd'], 2) }}</div>
    </div>
</div>

<!-- Tabla Principal -->
<table>
    <thead>
        <tr>
            <th style="width: 3%;">#</th>
            <th style="width: 15%;">Empresa (Área)</th>
            <th style="width: 20%;">Curso</th>
            <th style="width: 8%;">Inscritos</th>
            <th style="width: 8%;">Precio (Bs)</th>
            <th style="width: 12%;">Encargado</th>
            
            <!-- Columnas de bancos dinámicas -->
            @foreach($bancosUnicos as $banco)
                <th style="width: {{ 20 / count($bancosUnicos) }}%;">{{ $banco }}</th>
            @endforeach
            
            <th style="width: 10%;">Total Ventas</th>
            <th style="width: 8%;">Plan Pagos</th>
            <th style="width: 8%;">Pagos CD</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
            <tr>
                <td class="numero-col">{{ $index + 1 }}</td>
                <td class="empresa-col">{{ $item['empresa'] }}</td>
                <td class="curso-col">{{ $item['curso'] }}</td>
                <td class="numero-col">{{ number_format($item['total_inscritos']) }}</td>
                <td>{{ number_format($item['precio'], 2) }}</td>
                <td>{{ $item['encargado'] }}</td>
                
                <!-- Datos de bancos -->
                @foreach($bancosUnicos as $banco)
                    <td class="banco-col">
                        @php
                            $count = $item['pagos_por_banco'][$banco] ?? 0;
                        @endphp
                        @if($count > 0)
                            <span class="banco-count">{{ $count }}</span>
                        @else
                            <span class="banco-count zero">0</span>
                        @endif
                    </td>
                @endforeach
                
                <td class="money">{{ number_format($item['total_ventas_curso'], 2) }}</td>
                <td>{{ number_format($item['total_plan_pagos'], 2) }}</td>
                <td>{{ number_format($item['total_pagos_cd'], 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="3"><strong>TOTALES GENERALES</strong></td>
            <td><strong>{{ number_format($totales['total_inscritos']) }}</strong></td>
            <td>-</td>
            <td>-</td>
            
            <!-- Totales por banco -->
            @foreach($bancosUnicos as $banco)
                <td><strong>{{ $totalesPorBanco[$banco] ?? 0 }}</strong></td>
            @endforeach
            
            <td><strong>{{ number_format($totales['total_ventas_curso'], 2) }}</strong></td>
            <td><strong>{{ number_format($totales['total_plan_pagos'], 2) }}</strong></td>
            <td><strong>{{ number_format($totales['total_pagos_cd'], 2) }}</strong></td>
        </tr>
    </tfoot>
</table>

<!-- Resumen por Métodos de Pago -->
@if($bancosUnicos->count() > 0)
<div class="resumen-bancos">
    <div class="resumen-title">RESUMEN POR MÉTODO DE PAGO</div>
    <div class="bancos-grid">
        @foreach($bancosUnicos as $banco)
            <div class="banco-item">
                <div class="banco-name">{{ strtoupper($banco) }}</div>
                <div class="banco-total">{{ $totalesPorBanco[$banco] ?? 0 }}</div>
                <div style="font-size: 8px; color: #666;">transacciones</div>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="footer">
    <strong>Generado por:</strong> {{ $usuario }} | 
    <strong>Fecha:</strong> {{ $fechaGeneracion }}
</div>

</body>
</html>