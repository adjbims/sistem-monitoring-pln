<!DOCTYPE html>
<html>

<head>
		<title>Notifikasi Transaksi</title>
</head>

<body style="font-family: sans-serif; background-color: #f4f4f4; padding: 20px;">
		<div style="background-color: #fff; padding: 30px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
				<h1 style="color: #333; margin-bottom: 20px;">Notifikasi Transaksi</h1>
				<p style="margin-bottom: 10px;">Kepada Yth. {{ $data['name'] }},</p>
				<p style="margin-bottom: 20px;">{{ $data['message'] }}</p>
				<p style="font-size: 12px; color: #777;">Tanggal: {{ $data['date'] }}</p>
		</div>
</body>

</html>
