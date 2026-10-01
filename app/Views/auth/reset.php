<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }

        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }

        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }

        h2 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 2rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }

        h3 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 1rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }

        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }

        pre {
            white-space: normal;
            margin-top: 1.5rem;
        }

        code {
            background: #fafafa;
            border: 1px solid #efefef;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            display: block;
        }

        p {
            margin-top: 1.5rem;
        }

        .footer {
            margin-top: 2rem;
            border-top: 1px solid #efefef;
            padding: 1em 2em 0 2em;
            font-size: 85%;
            color: #999;
        }

        a:active,
        a:link,
        a:visited {
            color: #dd4814;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <img src="/dist/img/reset_ill.png" style="width:auto;height:300px">
        <h2>Your password has expired, please contact admin!</h2>
    </div>
</body>

</html>