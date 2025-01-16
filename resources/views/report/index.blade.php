@extends('apps.layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">Sales Report</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('report.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="periode" class="form-label fw-bold">Periode (Bulan & Tahun)</label>
                <input
                    type="month"
                    id="periode"
                    name="periode"
                    class="form-control"
                    value="{{ request('periode', now()->format('Y-m')) }}"
                >
            </div>
            <div class="col-md-4">
                <label for="outlets" class="form-label fw-bold">Outlet</label>
                <select
                    id="outlets"
                    name="outlets[]"
                    class="form-select selectpicker"
                    data-live-search="true"
                    multiple
                >
                    @foreach ($outlets as $outlet)
                        <option
                            value="{{ $outlet->OutletID }}"
                            {{ in_array($outlet->OutletID, request('outlets', [])) ? 'selected' : '' }}
                        >
                            {{ $outlet->OutletName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="view" class="btn btn-primary me-2">
                    <i class="bi bi-eye"></i> View
                </button>
                <button type="submit" name="export" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Export to Excel
                </button>
                <a href="{{ route('report.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </form>

    <!-- Report Table -->
    @if (!empty($reportData))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Periode</th>
                        <th>Outlet</th>
                        <th>Region</th>
                        <th>Salesman ID</th>
                        <th>Salesman Name</th>
                        <th>Penjualan</th>
                        <th>Jumlah Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $row)
                        <tr>
                            <td>{{ $row->Periode }}</td>
                            <td>{{ $row->OutletName }}</td>
                            <td>{{ $row->Region }}</td>
                            <td>{{ $row->SalesmanID }}</td>
                            <td>{{ $row->SalesmanName }}</td>
                            <td>{{ number_format($row->Penjualan, 2) }}</td>
                            <td>{{ $row->JumlahTransaksi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> No data available for the selected period and outlet(s).
        </div>
    @endif
</div>
@endsection
