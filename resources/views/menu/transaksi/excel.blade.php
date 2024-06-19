<table class="table-bordered table" id="dataTable" width="100%" cellspacing="0">
		<thead>
				<tr>
						<th>No</th>
						<th>Nama Lengkap</th>
						<th>Email</th>
						<th>Tipe</th>
						<th>Tanggal</th>
						<th>File</th>
						<th>created_at</th>
						<th>Action</th>
				</tr>
		</thead>
		<tbody>
				@foreach ($data as $row)
						<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $row->user->name }} {{ $row->user->last_name }}</td>
								<td>{{ $row->user->email }}</td>
								<td>{{ $row->user->pegawai->tipe }}</td>
								<td>{{ $row->tanggal }}</td>
								<td><a href="{{ asset('storage/bukti_transfer/' . $row->bukti_transfer) }}"
												target="_blank">{{ $row->bukti_transfer }}</a></td>
								<td>{{ $row->created_at }}</td>
						</tr>
				@endforeach
		</tbody>
</table>
