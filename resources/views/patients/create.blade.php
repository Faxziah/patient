<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление пациента</title>
</head>
<body>

@if ($errors->any())
    <div style="background-color: #f1bebc; padding: 20px">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: #700a01; padding-right: 20px">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="margin-top: 30px">
    <form action=" {{ route("patients.store") }}" method="post" style="display: flex; flex-direction: column; margin: auto; width: 250px">
        @csrf
        <input type="text" name="first_name" placeholder="Имя" value="{{ old('first_name') }}" required>
        <input type="text" name="last_name" placeholder="Фамилия" value="{{ old('last_name') }}" required>
        <input type="date" name="birthday" placeholder="Дата рождения" value="{{ old('birthday') }}" required>
        <button>Добавить пациента</button>
    </form>
</div>
</body>
</html>