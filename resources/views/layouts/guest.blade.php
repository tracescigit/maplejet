<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
 <style>
        :root {
            --body_gradient_left:#ffffff;
            --body_gradient_right: #ffffff;
            --form_bg: #ffffff47;
            --input_bg: #e3e3e3;
            --input_hover:#e3e3e3;
            --submit_bg: linear-gradient(45deg, #700877 0%, #ff2759 100%);
            --submit_hover: #dddddd59;
            --icon_color: #000000;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            /* make the body full height*/
            height: 100vh;
            /* set our custom font */
            font-family: 'Roboto',
                sans-serif;
            /* create a linear gradient*/
            background-image: linear-gradient(to right, var(--body_gradient_left), var(--body_gradient_right));
            /* display: flex; */
        }

        #form_wrapper {
            width: 1000px;
            height: 700px;
            /* this will help us center it*/
            margin: auto;
            background-color: var(--form_bg);
            border-radius: 0px;
            /* make it a grid container*/
            display: grid;
            /* with two columns of same width*/
            grid-template-columns: 1fr 1fr;
            /* with a small gap in between them*/
            grid-gap: 5vw;
            /* add some padding around */
            padding: 5vh 15px;
            margin-top: 110px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        #form_left {
            /* center the image */
            display: block;
            justify-content: center;
            align-items: center;
        }

        #form_left img {
            /* width: 100px; */
            /* height: 350px; */
            /* /* margin-left: 80px; */
            max-width: 550px;
            margin-top: 75px;
        }

        #form_right {
            display: grid;
            /* single column layout */
            grid-template-columns: 1fr;
            /* have some gap in between elements*/
            grid-gap: 20px;
            /* padding: 25% 5%; */
        }
        .logo-tracesci{
          /* margin: auto !important; */
            width: 300px;
        }

        h1,
        span {
            text-align: center;
        }

        .input_container {
            background-color: var(--input_bg);
            /* vertically align icon and text inside the div*/
            display: flex;
            align-items: center;
            padding-left: 20px;
        }

        /* .input_container:hover {
            background-color: #ffffff;
        } */

        .input_container,
        #input_submit {
            height: 60px;
            /* make the borders more round */
            border-radius: 10px;
            width: 100%;
        }

        .input_field {
            /* customize the input tag with lighter font and some padding*/
            color: var(--icon_color);
            /* background-color: inherit; */
            width: 90%;
            border: none;
            font-size: 1.3rem;
            font-weight: 400;
            padding-left: 30px;
            border-color: ;
        }

        .input_field:hover,
        .input_field:focus {
            /* remove the outline */
            outline: none;
        }

        #input_submit {
            /* submit button has a different color and different padding */
            background: var(--submit_bg);
            padding-left: 0;
            margin-top: 40px;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }

        #input_submit:hover {
            background-color: var(--submit_hover);
            /* simple color transition on hover */
            transition: background-color,
                1s;
            cursor: pointer;
        }


        /* shift it a bit lower 
        #create_account {
            display: block;
            position: relative;
            top: 30px;
        /* } */

        a {
            /* remove default underline */
            text-decoration: none;
            color: var(--submit_bg);
            font-weight: bold;
        }

        a:hover {
            color: var(--submit_hover);
        }

        i {
            color: var(--icon_color);
        }

        /* .logo img{
     width:200px; 
    height:50px;
    margin-bottom: 60px;
    margin-left: 140px;
} */

        /* make it responsive */
        @media screen and (max-width:768px) {

            /* make the layout  a single column and add some margin to the wrapper */
            #form_wrapper {
                grid-template-columns: 1fr;
                margin-left: 10px;
                margin-right: 10px;
            }

            /* on small screen we don't display the image */
            #form_left {
                display: none;
            }
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased" >
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <!-- <div class="hello">
            <img src="{{tracesciimg('logo.png')}}" alt="" class="img-fluid mb-0 w-50" style="max-width:11%;margin:auto;">
            <p class="mb-4 text-center text-muted px-2">Enterprise (V1.0.0.3)</p>
        </div> -->

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>