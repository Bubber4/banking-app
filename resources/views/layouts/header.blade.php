<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <header class="grid-container">
            <h1>Blue Core | Banking app</h1>
            <hr>
            <ul>
                <li>
                    <h2><a href="/">Home</a></h2>
                </li>
                <li>
                    <h2>Branches</h2>
                    <ul>
                        <li>
                            <a href="{{ route('branch.index') }}">List all branches</a>
                        </li>
                        <li>
                            <a href="{{ route('branch.create') }}">Create a new branch</a>
                        </li>
                        <li>
                            <a href="{{ route('branch.top') }}">List branches with +50k and >2 customers</a>
                        </li>
                    </ul>
                </li>
                <li> 
                    <h2>Customers</h2>
                    <ul>
                        <li>
                            <a href="{{ route('customer.index') }}">List all customers</a>
                        </li>
                        <li>
                            <a href="{{ route('customer.create') }}">Create a new customer</a>
                        </li>
                    </ul>
                </li>
                <!-- <li>
                    <h2>Transfers</h2>
                    <ul>
                        <li>
                            <a href="/branch">List all transfers</a>
                        </li>
                    </ul>
                </li> -->
            </ul>
            <hr>
        </header>