<table>
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
                <td>{{ $t->expense == 0 ? '-' : $t->expense }}</td>
                <td>{{ $t->income == 0 ? '-' : $t->income }}</td>
                <td>{{ $t->running_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
