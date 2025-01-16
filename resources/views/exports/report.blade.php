<table>
    <thead>
        <tr>
            <th>Periode</th>
            <th>Region</th>
            <th>Salesman ID</th>
            <th>Salesman Name</th>
            <th>Penjualan</th>
            <th>Jumlah Outlet</th>
            <th>Jumlah Outlet 3x Trans</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportData as $row)
            <tr>
                <td>{{ $row->Periode }}</td>
                <td>{{ $row->Region }}</td>
                <td>{{ $row->SalesmanID }}</td>
                <td>{{ $row->SalesmanName }}</td>
                <td>{{ $row->Penjualan }}</td>
                <td>{{ $row->JumlahOutlet }}</td>
                <td>{{ $row->JumlahOutlet3xTrans }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
