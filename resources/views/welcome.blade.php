<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-KyZXEJ6Jtpu9ay0w7OCk8nR2HfejF2pxp5Z2t8pqLwzG3xxN3XkL9Pso8toftx2j" crossorigin="anonymous">
    </head>
    <body>
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">
            <div style="text-align: center;">
                <p>{{ trans('messages.welcome', ['version' => \Zuno\Application::VERSION]) }}</p>
                <div>
                    <a href="https://github.com/techmahedy/zunoo" class="btn btn-light"
                        style="padding: 10px 20px; margin: 5px;">Github</a>
                    <a href="https://github.com/techmahedy/zunoo" class="btn btn-light"
                        style="padding: 10px 20px; margin: 5px;">Documentation</a>
                </div>
            </div>
        </div>
    </body>
</html>
