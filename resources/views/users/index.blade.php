<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Csv Import</title>
</head>
<body>

    <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <input type="file" name="file" id="file" accept=".csv"><br><br>
        <button type="submit" id="import_file">Importar</button>

    </form>

    @foreach ($users as $user)
        {{ $user->id }}
    @endforeach

</body>
</html>
