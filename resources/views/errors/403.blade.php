<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name'); }}</title>
    <meta name="author" content="Lacy" />
    <link rel="icon shortcut" type="image/png" href="{{ url('storage/img/favicon.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kode+Mono:wght@400..700&display=swap" rel="stylesheet">
<body>
<style>
    .kode-mono {
        font-family: "Kode Mono", monospace;
        font-optical-sizing: auto;
        font-weight: 20;
        font-style: normal;
    }
</style>

<center>
    <a href="/dashboard">
        <img src="/storage/img/logo.png" style="width: 25%; height: auto" alt="Logo"><br>
    </a>
    <h1 class="kode-mono">403 - Accès refusé</h1>
    <a href="{{ url()->previous() }}">
        <h3 class="kode-mono">Retourner en arrière</h3>
    </a>
</center>

</body>
</html>
