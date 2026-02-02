<h3>Laporan Keuangan</h3>

<table width="100%" border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Kode</th>
            <th>Keluar</th>
            <th>Masuk</th>
            <th>Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->date }}</td>
                <td>{{ $t->description }}</td>
                <td>{{ $t->code }}</td>
                <td>{{ $t->expense == 0 ? '-' : number_format($t->expense) }}</td>
                <td>{{ $t->income == 0 ? '-' : number_format($t->income) }}</td>
                <td>{{ number_format($t->running_total) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
