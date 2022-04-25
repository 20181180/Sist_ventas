<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotizacion</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css')}}" type="text/css">
</head>

<body>

    <section class="header" style="top: -287px;">
        <table cellpadding="2" cellspacing="0" width="100%">
            <tr>
                <td colspan="4" class="text-center">
                    <span style="font-size: 25px; font-wight: bold;">{{$infoE->empresa}} S.A de CV.</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <img src="{{asset('storage/datos/' . $infoE->image)}}" alt="" class="invoice-logo">
                </td>
                <td colspan="2" class="text-left text-company" width="70%" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 16px"> <strong>Cotizacion de productos.</strong> </span>
                    <br>
                    <span style="font-size: 16px"> <strong>Fecha de consulta: {{ \Carbon\Carbon::now()->format('d-M-Y')}}.</strong> </span>
                    <br>
                    <span style="font-size: 16px"> <strong>Lo atiende: {{$user}}</strong> </span>
                    <br>
                </td>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <u>
                        <span style="font-size: 13px;font-wight:bold" aling="left"> Clave #: {{$clav_id}} </span>

                    </u>

                    <br>
                    <br>
                    <u style="color: red;"> <span style="font-size: 13px;font-wight:bold"> Expiracion:{{$fechaV->format('d-M-Y')}}. </span></u>

                    <br>
                    <br>
                    <span style="font-size: 13px;font-wight:lighter"> Meripuntos : {{$points}} mptos. </span>
                </td>

            </tr>

        </table>

    </section>
    <section style="margin-top: -110px">
        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
            <thead>
                <tr>
                    <th width="10%">FOLIO</th>
                    <th width="12%">NOMBRE</th>
                    <th width="12%">CANTIDAD</th>
                    <th width="10%">SUBTOTAL</th>
                    <th width="12%">IMAGEN</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td align="center">{{$item->id}}</td>
                    <td align="center">{{$item->name}}</td>
                    <td align="center">{{$item->quantity}}</td>
                    <td align="center">$ {{$item->price}}</td>
                    <td align="center"><img src="{{ asset('storage/products/' . $item->attributes[0]) }}" alt="imagen de productos" height="50" width="50" class="rounded"></td>
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center">

                    </td>
                    <td class="text-center">
                        <span><b>TOTAL</b></span>
                    </td>
                    <td class="text-center">
                        {{$items}} Articulos
                    </td>
                    <td class="text-center">
                        <span><strong>= $ {{$total}} MXN</strong></span>
                    </td>

                    <td class="text-center">

                    </td>

                </tr>
            </tfoot>
        </table>
    </section>
    <section class="footer">
        <table cellpadding="0" cellspacing="0" witdh="100%" class="table-items">
            <tr>
                <td width="20%">
                    <span>Sistema de ventas MerijoMechatronics</span>
                </td>
                <td width="60%" class="text-center">
                    MerijoMechatronics
                </td>
                <td width="20%" class="text-center">
                    pagina <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>