<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Welcome <?= session()->get('name'); ?> 👋</h1>

    <p>Ini halaman admin dashboard.</p>

    <form method="post" action="/logout">
    <?= csrf_field(); ?>
    <button type="submit">Logout</button>
</form>

</body>
</html>