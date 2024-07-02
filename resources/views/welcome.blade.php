<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
        html{box-sizing:border-box;font:16px/1.5 Georgia,'Times New Roman',Times,serif}*,::after,::before{box-sizing:inherit}*{margin:0;padding:0}body{overflow-x:hidden;min-height:100vh;display:flex;flex-direction:column;gap:6em}.site-header{padding-top:1em;display:flex;flex-wrap:wrap;justify-content:space-around;align-items:center}.site-header p{color:purple;font-size:1.5em;font-weight:700}.site-header p::after{display:block;content:'The last Web Agency you will ever need';color:#000;font-weight:400;text-transform:uppercase;font-size:1rem;letter-spacing:-.03rem}.site-navigation ul{display:flex;gap:1.5em}.site-navigation ul li{display:block;list-style:none}.site-navigation ul li a{color:#000;text-decoration:none;font-size:1.2em}.site-main{padding-bottom:6em;display:flex;flex-direction:column;align-items:center;gap:6em}.site-main .main-header{max-width:50%;display:flex;align-items:center}.site-main .main-header article{flex:1 1 60%;display:flex;flex-direction:column;gap:1em}.site-main .main-header article h1{font-size:1.5rem}.site-main .main-header article a{align-self:flex-start;padding:.5em 1em;color:#000;text-decoration:none;border:.1em solid #000;border-radius:.3em;transition:box-shadow .4s ease-in-out}.site-main .main-header article a:hover{box-shadow:0 0 1em 0 rgba(0,0,0,.5)}.site-main .main-header svg{flex:1 1 20%;font-size:10em;scale:1;transition:scale .4s ease-in-out}.site-main .main-header svg:hover{scale:1.1}.site-main .our-team-section,.site-main .testimonials-section{max-width:50%}
    </style>
</head>

<body>
    <main class="site-main" style="margin-top: 100px;">
        <section class="main-header">
            <article>
                <h1>Welcome to MII Framework</h1>
                <p>MII, A powerful PHP MVC framework design in a way that you feel like you are working in a Laravel
                    application. In this framework you will get all the basic features of a web application needs like
                    routing, middleware, dependency injection, eloquent relationship, model, blade template engine and
                    interface injection and many mores. Test it and if you like, please give a star to it.</p>
                <a href="https://github.com/techmahedy/mini-laravel">Documentation</a>
                <h3>Version: {{ \Mii\Application::VERSION }}</h3>
            </article>
            <svg xmlns="http://www.w3.org/2000/svg" height="1em"
                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M57.7 193l9.4 16.4c8.3 14.5 21.9 25.2 38 29.8L163 255.7c17.2 4.9 29 20.6 29 38.5v39.9c0 11 6.2 21 16 25.9s16 14.9 16 25.9v39c0 15.6 14.9 26.9 29.9 22.6c16.1-4.6 28.6-17.5 32.7-33.8l2.8-11.2c4.2-16.9 15.2-31.4 30.3-40l8.1-4.6c15-8.5 24.2-24.5 24.2-41.7v-8.3c0-12.7-5.1-24.9-14.1-33.9l-3.9-3.9c-9-9-21.2-14.1-33.9-14.1H257c-11.1 0-22.1-2.9-31.8-8.4l-34.5-19.7c-4.3-2.5-7.6-6.5-9.2-11.2c-3.2-9.6 1.1-20 10.2-24.5l5.9-3c6.6-3.3 14.3-3.9 21.3-1.5l23.2 7.7c8.2 2.7 17.2-.4 21.9-7.5c4.7-7 4.2-16.3-1.2-22.8l-13.6-16.3c-10-12-9.9-29.5 .3-41.3l15.7-18.3c8.8-10.3 10.2-25 3.5-36.7l-2.4-4.2c-3.5-.2-6.9-.3-10.4-.3C163.1 48 84.4 108.9 57.7 193zM464 256c0-36.8-9.6-71.4-26.4-101.5L412 164.8c-15.7 6.3-23.8 23.8-18.5 39.8l16.9 50.7c3.5 10.4 12 18.3 22.6 20.9l29.1 7.3c1.2-9 1.8-18.2 1.8-27.5zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z" />
            </svg>
        </section>
    </main>
</body>

</html>
