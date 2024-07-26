<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TRACESCI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <style>
        :root {
            --body_gradient_left:#ffffff;
            --body_gradient_right:#ffffff;
            --form_bg: #ffffff;
            --input_bg: #8d8080;
            --input_hover: #eaeaea;
            --submit_bg: #000000;
            --submit_hover: #32301d47;
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
            display: flex;
        }

        #form_wrapper {
            width: 1000px;
            height: 700px;
            /* this will help us center it*/
            margin: auto;
            background-color: var(--form_bg);
            border-radius: 50px;
            /* make it a grid container*/
            display: grid;
            /* with two columns of same width*/
            grid-template-columns: 1fr 1fr;
            /* with a small gap in between them*/
            grid-gap: 5vw;
            /* add some padding around */
            padding: 5vh 15px;
        }

        #form_left {
            /* center the image */
            display: block;
            justify-content: center;
            align-items: center;
           
        }

        #form_left img {
            width: 350px;
            /* height: 350px; */
            max-width: 600px !important;
        }

        #form_right {
            display: grid;
            /* single column layout */
            grid-template-columns: 1fr;
            /* have some gap in between elements*/
            grid-gap: 20px;
            padding: 10% 5%;
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

        .input_container:hover {
            background-color: var(--input_hover);
        }

        .input_container,
        #input_submit {
            height: 60px;
            /* make the borders more round */
            border-radius: 30px;
            width: 100%;
        }

        .input_field {
            /* customize the input tag with lighter font and some padding*/
            color: var(--icon_color);
            background-color: inherit;
            width: 90%;
            border: none;
            font-size: 1.3rem;
            font-weight: 400;
            padding-left: 30px;
        }

        .input_field:hover,
        .input_field:focus {
            /* remove the outline */
            outline: none;
        }

        #input_submit {
            /* submit button has a different color and different padding */
            background-color: var(--submit_bg);
            padding-left: 0;
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


        /* shift it a bit lower */
        #create_account {
            display: block;
            position: relative;
            top: 30px;
        }

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
</head>

<body>

    <div id="form_wrapper">

        <div id="form_left">
            <img src="{{tracesciimg('icon.png')}}" alt="computer icon">
            <img src="{{tracesciimg('logo.png')}}" alt="computer icon">
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div id="form_right">
                <h1>Member Login</h1>
                <div class="input_container">
                    <i class="fas fa-envelope"></i>
                    <input placeholder="Email" type="email" name="Email" id="field_email" class='input_field'>
                </div>
                <div class="input_container">
                    <i class="fas fa-lock"></i>
                    <input placeholder="Password" type="password" name="Password" id="field_password" class='input_field'>
                </div>
                <button type="submit" id='input_submit' class='btn input_field'>Login</button>
                <span>Forgot <a href="#"> Username / Password ?</a></span>
                <span id='create_account'>
                    <a href="#">Create your account &#x27A1; </a>
                </span>

            </div>
        </form>
    </div>
</body>

</html>