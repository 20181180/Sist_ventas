<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CATALOGO DE PRODUCTOS</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css')}}" type="text/css">

    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <section class="header" style="top: -287px;">
        <table cellpadding="0" cellspacing="4" width="100%">
            <tr>
                <td colspan="5" class="text-center text-company">
                    <span style="font-size: 20px; font-wight: bold;"> <strong> {{$infoE->empresa}} S.A de CV.</strong></span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <img src="{{asset('storage/datos/' . $infoE->image)}}" alt="" class="invoice-logo">
                </td>
                <td colspan="3" class="text-left text-company" width="70%" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 16px"> <strong>CATALOGO DE PRODUCTOS</strong> </span>
                    <br>
                    <span style="font-size: 16px"> <strong>Fecha de consulta: {{ \Carbon\Carbon::now()->format('d-M-Y')}}</strong> </span>
                    <br>
                    <span style="font-size: 16px;">Lo atiende: <strong style="text-transform: uppercase;"> {{$user}}</strong> </span>
                    <br>
                </td>
                <td width="30%" style="vertical-align: top; padding-top: 15px; position: relative">

                    <span style="font-size: 13px;font-wight:bold" aling="left"> Telefono :{{$infoE->tel}} </span>

                    <br>
                    <br>
                    <span style="font-size: 13px;font-wight:bold;text-transform: uppercase;" aling="left"> Direccion :{{$infoE->ubicacion}} </span>
                    <br>
                    <br>
                    <u style="color: red;"> <span style="font-size: 13px;font-wight:bold"> E-Mail:{{$infoE->correo}} </span></u>

                </td>
            </tr>

        </table>

    </section>
    <section style="margin-top: -110px">


        @foreach ($data as $item)
        <div class="page-break" cellpadding="0">
            <div class="card text-center">
                <div class="card-header">

                    <p class="card-text text-company" style="font-size: 14px;text-decoration: underline;">
                        <strong style="font-size: 14px;text-transform: uppercase;">
                            NOMBRE DEL PRODUCTO: {{$item->name}}
                        </strong>

                    </p>

                </div>
                <img src="{{ asset('storage/products/' . $item->image) }}" height="65px" width="65%" class="card-img-top" alt="...">
                <div class="card-body">
                    <p class="card-text text-company" style="font-size: 14px;">PRODUCTOS STOCK: {{$item->stock}} </p>

                    <p class="card-text text-company" style="font-size: 14px">PRECIO UNITARIO: $ {{$item->price}} MXNS </p>

                    <p class="card-text text-company" style="font-size: 14px">MERIPUNTOS: $ {{$item->price /10*100}} MXNS </p>

                    <p class="card-text text-company" style="font-size: 14px">CODIGO DEL PRODUCTO: {{$item->barcode}} </p>
                </div>



            </div>
        </div>


        @endforeach



    </section>
    <section class="footer">
        <table cellpadding="0" cellspacing="0" witdh="100%" class="table-items">
            <tr>
                <td width="20%">
                    <span>{{$infoE->empresa}} /</span>
                </td>
                <td width="60%" class="text-center">
                    Facebook {{$infoE->face}} / CP {{$infoE->codigopostal}}
                </td>
                <td width="20%" class="text-center">
                    pagina <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>