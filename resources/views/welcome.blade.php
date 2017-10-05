<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Order-Tagger</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
        $(function(){
        // var id = Shopify.checkout.order_id;
        // if (id == null) {window.location.reload(true);}
        // var date = window.localStorage.getItem("delivery_date");
        var url =  'https://saaraketha-organics.myshopify.com/admin/orders/4990583621.json';
        // console.log(Shopify.checkout.order_id);
        // console.log(Shopify.checkout);
        // console.log(Shopify);
        // console.log(id);
        // console.log(date);
        // console.log(url);
         $.ajax({
                    type: 'GET',
                            url: url,
                            crossDomain: true,
                                beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', 'Basic ' + window.btoa(unescape(encodeURIComponent('3e0ea0b497d2c61c9c65772d128b0ac1:42a3bd866aa6debd4a2c172606a883ff'))))
                            },
                            success: function (data) {
                                console.log(data);
                            }
                  });    
            });
        });
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Order-Tagger
                </div>

                <div class="links">
                    <a href="https://3e0ea0b497d2c61c9c65772d128b0ac1:42a3bd866aa6debd4a2c172606a883ff@saaraketha-organics.myshopify.com/admin/orders/4990583621.json">Test API call</a>
                </div>
            </div>
        </div>
    </body>
</html>
