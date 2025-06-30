<div>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>{{ $title ?? 'Registrasi Page' }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(to bottom right, #004aad, #015ef2);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .login-card {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                max-width: 900px;
                width: 100%;
            }

            .login-image {
                background: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px;
            }

            .login-form {
                padding: 40px;
            }

            .form-control {
                border-radius: 10px;
            }

            .btn-login {
                background-color: #004aad;
                color: #fff;
                border-radius: 10px;
            }

            .btn-login:hover {
                background-color: #003080;
                color: rgb(198, 198, 198);
            }

            .text-small {
                font-size: 0.9rem;
            }

            .img-fluid {
                max-width: 300px;
            }
        </style>
    </head>

    <body>
        {{ $slot }}

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>
</div>