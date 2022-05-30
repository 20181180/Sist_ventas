<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COMPROBANTE DE PAGO</title>
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
                <td class="text-left text-company" width="70%" style="vertical-align: top; padding-top: 10px">
                    <span style="font-size: 16px"> <strong>Comprobante de Venta.</strong> </span>
                    <br>
                    <span style="font-size: 16px"> <strong>Fecha de consulta: {{ \Carbon\Carbon::now()->format('d-M-Y')}}</strong> </span>
                    <br>
                    <span style="font-size: 16px"> <strong>Lo atiende: {{$user}}</strong> </span>
                    <br>
                </td>


                <br>
                <span style="font-size: 13px;font-wight:lighter"> TEL: {{$infoE->tel}} </span>

                <br>
                <br>
                <span style="font-size: 13px;font-wight:lighter"> E-Mail: {{$infoE->correo}} </span>
            </tr>

        </table>

    </section>
    <section style="margin-top: -110px">
        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">

            <thead>

                <tr>

                    <th width="10%">FOLIO</th>
                    <th width="12%">PRODUCTO</th>
                    <th width="12%">CANTIDAD</th>
                    <th width="10%">PRECIO</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td align="center">{{$item->id}}</td>
                    <td align="center">{{$item->name}}</td>
                    <td align="center">{{$item->quantity}}</td>
                    <td align="center">$ {{$item->price}}</td>

                </tr>
                @endforeach
            </tbody>

            <tfoot>

                <tr>

                    <td class="text-center">
                        <span><b></b></span>
                    </td>
                    <td class="text-center">

                    </td>
                    <td class="text-center">
                        <br><br>
                        <span><strong>{{$total}} Art</strong></span>
                    </td>

                    <td class="text-center">
                        <br><br>
                        Total: ${{$items}} MXN
                    </td>


                </tr>
            </tfoot>
        </table>
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