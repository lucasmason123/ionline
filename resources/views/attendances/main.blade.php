<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .font-robo {
            font-family: roboto, arial, helvetica neue, sans-serif
        }

        .row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap
        }

        .row-space {
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -moz-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between
        }

        .col-2 {
            width: -webkit-calc((100% - 60px)/2);
            width: -moz-calc((100% - 60px)/2);
            width: calc((100% - 60px)/2)
        }

        @media(max-width:767px) {
            .col-2 {
                width: 100%
            }
        }

        html {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box
        }

        * {
            padding: 0;
            margin: 0
        }

        *,
        *:before,
        *:after {
            -webkit-box-sizing: inherit;
            -moz-box-sizing: inherit;
            box-sizing: inherit
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        blockquote,
        p,
        pre,
        dl,
        dd,
        ol,
        ul,
        figure,
        hr,
        fieldset,
        legend {
            margin: 0;
            padding: 0
        }

        li>ol,
        li>ul {
            margin-bottom: 0
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        fieldset {
            min-width: 0;
            border: 0
        }

        button {
            outline: none;
            background: 0 0;
            border: none
        }

        .page-wrapper {
            min-height: 100vh
        }

        body {
            font-family: roboto, arial, helvetica neue, sans-serif;
            font-weight: 400;
            font-size: 14px
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 400
        }

        h1 {
            font-size: 36px
        }

        h2 {
            font-size: 30px
        }

        h3 {
            font-size: 24px
        }

        h4 {
            font-size: 18px
        }

        h5 {
            font-size: 15px
        }

        h6 {
            font-size: 13px
        }

        .bg-blue {
            background: #2c6ed5
        }

        .bg-green {
            background: #57b846
        }

        .bg-yellow {
            background: #FFC436
        }

        .bg-red {
            background: #fa4251
        }

        .p-t-100 {
            padding-top: 100px
        }

        .p-t-180 {
            padding-top: 180px
        }

        .p-t-20 {
            padding-top: 20px
        }

        .p-t-30 {
            padding-top: 30px
        }

        .p-b-100 {
            padding-bottom: 100px
        }

        .wrapper {
            margin: 0 auto
        }

        .wrapper--w960 {
            max-width: 960px
        }

        .wrapper--w680 {
            max-width: 680px
        }

        .btn {
            line-height: 40px;
            display: inline-block;
            padding: 0 25px;
            cursor: pointer;
            color: #fff;
            font-family: roboto, arial, helvetica neue, sans-serif;
            -webkit-transition: all .4s ease;
            -o-transition: all .4s ease;
            -moz-transition: all .4s ease;
            transition: all .4s ease;
            font-size: 14px;
            font-weight: 700
        }

        .btn--radius {
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px
        }

        .btn--green {
            background: #57b846
        }

        .btn--green:hover {
            background: #4dae3c
        }

        td.active {
            background-color: #2c6ed5
        }

        input[type=datei] {
            padding: 14px
        }

        .table-condensed td,
        .table-condensed th {
            font-size: 14px;
            font-family: roboto, arial, helvetica neue, sans-serif;
            font-weight: 400
        }

        .daterangepicker td {
            width: 40px;
            height: 30px
        }

        .daterangepicker {
            border: none;
            -webkit-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            -moz-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            display: none;
            border: 1px solid #e0e0e0;
            margin-top: 5px
        }

        .daterangepicker::after,
        .daterangepicker::before {
            display: none
        }

        .daterangepicker thead tr th {
            padding: 10px 0
        }

        .daterangepicker .table-condensed th select {
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            font-size: 14px;
            padding: 5px;
            outline: none
        }

        input {
            outline: none;
            margin: 0;
            border: none;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            width: 100%;
            font-size: 14px;
            font-family: inherit
        }

        .input-group {
            position: relative;
            margin-bottom: 32px;
            border-bottom: 1px solid #e5e5e5
        }

        .input-icon {
            position: absolute;
            font-size: 18px;
            color: #ccc;
            right: 8px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            -o-transform: translateY(-50%);
            transform: translateY(-50%);
            cursor: pointer
        }

        .input--style-2 {
            padding: 9px 0;
            color: #666;
            font-size: 16px;
            font-weight: 500
        }

        .input--style-2::-webkit-input-placeholder {
            color: gray
        }

        .input--style-2:-moz-placeholder {
            color: gray;
            opacity: 1
        }

        .input--style-2::-moz-placeholder {
            color: gray;
            opacity: 1
        }

        .input--style-2:-ms-input-placeholder {
            color: gray
        }

        .input--style-2:-ms-input-placeholder {
            color: gray
        }

        .select--no-search .select2-search {
            display: none !important
        }

        .rs-select2 .select2-container {
            width: 100% !important;
            outline: none
        }

        .rs-select2 .select2-container .select2-selection--single {
            outline: none;
            border: none;
            height: 36px
        }

        .rs-select2 .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 0;
            color: gray;
            font-size: 16px;
            font-family: inherit;
            font-weight: 500
        }

        .rs-select2 .select2-container .select2-selection--single .select2-selection__arrow {
            height: 34px;
            right: 4px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -moz-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -moz-box-align: center;
            -ms-flex-align: center;
            align-items: center
        }

        .rs-select2 .select2-container .select2-selection--single .select2-selection__arrow b {
            display: none
        }

        .rs-select2 .select2-container .select2-selection--single .select2-selection__arrow:after {
            font-family: material-design-iconic-font;
            content: '\f2f9';
            font-size: 18px;
            color: #ccc;
            -webkit-transition: all .4s ease;
            -o-transition: all .4s ease;
            -moz-transition: all .4s ease;
            transition: all .4s ease
        }

        .rs-select2 .select2-container.select2-container--open .select2-selection--single .select2-selection__arrow::after {
            -webkit-transform: rotate(-180deg);
            -moz-transform: rotate(-180deg);
            -ms-transform: rotate(-180deg);
            -o-transform: rotate(-180deg);
            transform: rotate(-180deg)
        }

        .select2-container--open .select2-dropdown--below {
            border: none;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            -moz-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            border: 1px solid #e0e0e0;
            margin-top: 5px;
            overflow: hidden
        }

        .title {
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 37px
        }

        .card {
            overflow: hidden;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            background: #fff
        }

        .card-2 {
            -webkit-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            -moz-box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            width: 100%;
            display: table
        }

        .card-2 .card-heading {
            background: url('../images/dinner.jpg') top left/cover no-repeat;
            width: 50.1%;
            display: table-cell
        }

        .card-2 .card-body {
            display: table-cell;
            padding: 80px 90px;
            padding-bottom: 88px
        }

        @media(max-width:767px) {
            .card-2 {
                display: block
            }

            .card-2 .card-heading {
                width: 100%;
                display: block;
                padding-top: 300px;
                background-position: left center
            }

            .card-2 .card-body {
                display: block;
                padding: 60px 50px
            }
        }
    </style>
</head>

<body>
    {{-- <div class="alert alert-success" role="success">
        Gracias por confirmar su asistencia a la fiesta
    </div> --}}


        <div class="page-wrapper bg-green p-t-180 p-b-100 font-robo">
            <div class="wrapper wrapper--w960">
                <div class="card card-2">
                    <div class="card-heading"></div>
                    <div class="card-body">
                        <h2 class="title">Gracias por su Confirmacion, {{ $nombre }}</h2>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
