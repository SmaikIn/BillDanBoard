<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля</title>
    <style>
        .button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="600"
       style="background-color: #fff; border-radius: 5px;">
    <tr>
        <td align="center" style="padding: 20px;">
            <img src="{{ asset('reset-password.svg') }}" alt="" width="150">
            <h2 style="text-align: center; margin-top: 20px;">Восстановление пароля</h2>
            <p style="text-align: center;">Вы получили это письмо, потому что мы получили запрос на восстановление пароля для вашей учетной записи.</p>
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $email]) }}"
               target="_blank" class="button">Сбросить пароль</a>
            <p style="text-align: center;">Если вы не запрашивали восстановление пароля, просто проигнорируйте это письмо.</p>
            <p style="text-align: center;">С уважением, Команда вашего сервиса</p>
        </td>
    </tr>
</table>
</body>
</html>
