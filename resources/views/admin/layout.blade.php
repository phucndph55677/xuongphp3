<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- CSS co dinh cua du an --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Nếu muốn mỗi trang 1 CSS riêng thì thêm CSS ở đây --}}
    @yield('css')
</head>

<body>
    <div class="container">
        <header>
            MENU
        </header>

        @yield('content')

        <footer>
            FOOTER
        </footer>
    </div>

    @yield('script')
</body>
</html>