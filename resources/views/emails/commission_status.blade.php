<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Commission {{ $status }}</title>
</head>
<body>
    <h3>📢 แจ้งเตือนสถานะ Commission</h3>
    <p>Commission ID: <b>{{ $commissionId }}</b></p>
    <p>สถานะล่าสุด: <b style="color: {{ $status == 'Approved' ? 'green' : 'red' }}">
        {{ $status }}
    </b></p>
    <hr>
    <p>-- ระบบ Commission Management --</p>
</body>
</html>
