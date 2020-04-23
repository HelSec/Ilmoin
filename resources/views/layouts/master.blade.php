<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ url(mix('assets/css/app.css')) }}">
    <title>
        @hasSection('title')
        @yield('title') &ndash;
        @endif
        {{ config('app.name', 'Ilmoin') }}</title>

    <script>
        window.Ilmoin = {
            basePath: '{{ url(route('home')) }}',
            api: {},
        };
    </script>

    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.11.2/css/all.css"
          crossorigin="anonymous">
</head>
<body class="font-sans antialiased text-gray-800 leading-tight bg-gray-300 border-t-8 border-pink-700">
<div id="app">
    <div class="bg-white leading-none shadow border-t-8 border-pink-500 p-6">
        <div class="container mx-auto md:flex justify-between">
            <div class="md:flex">
                <div>
                    <a href="{{ route('home') }}" class="bg-pink-200 hover:bg-pink-400 text-pink-800 font-bold p-2 mx-1 hover:underline">
                        {{ config('app.name', 'Ilmoin') }}</a>
                </div>

                @foreach([
                    'All Organizations' => route('organizations.index')
                ] as $title => $link)
                    <div>
                        <a href="{{ $link }}" class="p-2 mx-1 hover:bg-pink-300 hover:text-pink-900 hover:underline">
                            {{ $title }}
                        </a>
                    </div>
                @endforeach
            </div>

            <div>
                @auth
                    {{ Auth::user()->email }}

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log out
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="container max-md:px-2 md:mx-auto py-4">

        @if($errors->any())
            <div class="card card-no-bg bg-red-100 text-red-900">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(Session::has('notice'))
            <div class="card card-no-bg bg-blue-100 text-blue-900">
                <div>
                    {{ Session::get('notice') }}
                </div>
            </div>
        @endif

        @yield('content')

        <div class="text-center text-xs text-gray-600 mt-1">Powered by
            <a href="https://github.com/helsec/ilmoin" class="hover:underline">Ilmoin</a>{!! \App\Utils\Version::getVersion() !!}.
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script src="{{ url(mix('assets/js/app.js')) }}"></script>
</body>
</html>
