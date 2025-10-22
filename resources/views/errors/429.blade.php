<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>429 Too Many Requests</title>

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        /*--- Custom Styling for 429 ---*/
        .page_429 {
            padding: 40px 0;
            background: #fff;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        /* Assuming dribbble_1.gif is a suitable image for an error */
        .four_two_nine_bg {
            background-image: url("{{ asset('img/dribbble_1.gif') }}");
            height: 400px;
            background-position: center;
            background-repeat: repeat-y;
        }

        .four_two_nine_bg h1 {
            font-size: 72px;
            margin-bottom: 16px;
        }

        .contant_box_429 {
            margin-top: -50px;
        }

        .contant_box_429 h2 {
            font-size: 32px;
        }

        .contant_box_429 p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .link_429 {
            padding: 10px 20px;
            border-radius: 5px;
            margin: 20px 0;
            display: inline-block;
        }
    </style>
</head>

<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1 text-center">
                        <div class="four_two_nine_bg">
                            <h1 class="text-center">429</h1>
                        </div>

                        <div class="contant_box_429">
                            <h2>TOO MANY REQUESTS</h2>

                            <p>
                                You have exceeded the maximum allowed login attempts (5 attempts per 5 minutes).
                                <br>
                                Your access has been temporarily blocked for security reasons.
                                <br><br>
                                Please wait a few minutes before trying again.
                            </p>

                            <a href="{{ url()->previous() }}" class="link_429">
                                ⬅️Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>

</html>
