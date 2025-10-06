<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .page_404 {
            padding: 40px 0;
            background: #fff;
            font-family: 'Arvo', serif;
        }

        .text-center {
            text-align: center;
        }

        .page_404 img {
            width: 100%;
        }

        .four_zero_four_bg {

            background-image: url("{{ asset('img/dribbble_1.gif') }}");
            height: 400px;
            background-position: center;
            background-repeat: repeat-y;
        }


        .four_zero_four_bg h1 {
            font-size: 80px;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }

        .contant_box_404 {
            margin-top: -50px;

        }
    </style>
</head>

<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <div class="four_zero_four_bg">
                            <h1>405</h1>
                        </div>

                        <div class="contant_box_404">
                            <h3 class="h2">
                                Method Not Allowed
                            </h3>
                            <p>The HTTP method used in your request is not allowed for the requested resource.</p>
                            <p>This means the server understood your request, but the specific action you tried to
                                perform (e.g., submitting a form via POST to a page that only accepts GET) is not
                                permitted for this resource.</p>
                            <p>Please check the method you are using and ensure it is appropriate for the resource you
                                are trying to access.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
