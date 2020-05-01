<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #000{{ $invoice->id }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
    </style>

</head>
<body>

<table width="100%">
    <tr>
{{--        <td valign="top"><img src="" alt="" width="150"/></td>--}}
        <td align="left">
            <h3>
                <pre>
                Company Name : Affiliate Khatididh
                Company address : 196/A Amligola, Lalbag, Dhaka
                phone : 0147410147
                Web : www.khatidudh.com.bd
                Email : affiliate@gmail.com
                </pre>
            </h3>
        </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="left">
            <h3>
                <pre>
                  Bill To :
                  Name - {{ $invoice->InvoiceTable->UserTable->name }}
                  Phone - {{ $invoice->InvoiceTable->UserTable->phone }}
                  Address - {{ $invoice->InvoiceTable->UserTable->relationToProfile->address }}
                </pre>
            </h3>
        </td>
    </tr>
</table>


<table width="100%">
    <tr>
        <td align="right">
            <h3>
                @php
                    $mytime = Carbon\Carbon::now()->format('d-m-Y');
                @endphp
                Date : {{ $mytime }}
            </h3>
        </td>
    </tr>
</table>

<br/>

<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>Product Name</th>
        <th>Unit</th>
        <th>Unit Price</th>
        <th>Coupon Code</th>
        <th>Tax</th>
        <th>Package Price</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center">{{ $invoice->ProductTable->name }}<hr></td>
        <td align="center">{{ $invoice->ProductTable->unit }}<hr></td>
        <td align="center">{{ $invoice->ProductTable->unit_price }} Tk.<hr></td>
        <td align="center">{{ $invoice->InvoiceTable->coupon_code ?? 'Null'}}<hr></td>
        <td align="center">{{ $invoice->vat_tax }}%<br><hr></td>
        <td align="center">{{ $invoice->cash_discount }} Tk. [With Tax]<hr></td>
    </tr>
    </tbody>

    <tfoot>
    <tr>
        <td colspan="4"></td>
        <td align="right">Subtotal </td>
        <td align="center">{{ $invoice->cash_discount }} Tk.</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td align="right">Shipping(+) </td>
        <td align="center">50 TK.</td>
    </tr>
    <tr>
        <td colspan="4"></td>
        <td align="right">Coupon Discount(-) </td>
        @if(Str::endsWith($invoice->InvoiceTable->coupon_amount, '%'))
            <td align="center">{{ $invoice->InvoiceTable->coupon_amount ?? '0'}}</td>
        @else
            <td align="center">{{ $invoice->InvoiceTable->coupon_amount ?? '0'}} Tk.</td>
        @endif
    </tr>
    <tr>
        <td colspan="4"></td>
        <td align="right">Total </td>
        @if(Str::endsWith($invoice->InvoiceTable->coupon_amount, '%'))
        <td align="center" class="gray">
            {{ ($invoice->cash_discount+50) - (((Str::before($invoice->InvoiceTable->coupon_amount, '%')) * ($invoice->cash_discount+50)) / 100) }} TK.
        </td>
        @else
            <td align="center" class="gray">
                {{ $invoice->cash_discount+50-$invoice->InvoiceTable->coupon_amount }} TK.
            </td>
        @endif
    </tr>
    </tfoot>
</table>

</body>
</html>
