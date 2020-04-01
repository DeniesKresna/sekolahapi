<!DOCTYPE html>
<html>
<head>
    <title>nota</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css?<?php echo time(); ?>">
    <style type="text/css">
        *{
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        }

        .grid-container-50{
            display: grid;
            grid-template-columns: auto auto;
            padding: 5px;
        }
        .nota-title{
            padding: 0 10px;
            font-weight: bold;
        }
        .nota-list{
            display: grid;
            grid-template-columns: auto;
            padding: 5px 20px;
        }
        .nota-total{
            display: grid;
            grid-template-columns: auto;
            padding: 5px 20px;
        }
        .nota-list table{
            border-collapse: collapse;
            border-top: 1px solid black;
        }
        .nota-list th{
            border-collapse: collapse;
            border-bottom: 1px solid black;
            padding: 10px 0;
        }
        .nota-list td{
            padding: 5px 0;
        }
        .nota-total table{
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        .nota-total td{
            padding: 5px 0;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-bold{
            font-weight: bold;
        }
    </style>
</head>
<body>
<div>
    <?php $user = $transaction->user;?>
    <p class="nota-title">FAKTUR RETUR PEMBELIAN ONLINE</p>
    <div class="grid-container-50">
        <div class="grid-item">
            <div class="nota-id">
                <table>
                    <tr>
                        <td>Tanggal</td>
                        <td>&emsp;:&emsp;</td>
                        <td>{{date("d M Y")}}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>&emsp;:&emsp;</td>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>&emsp;:&emsp;</td>
                        <td>{{$user->address}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="nota-list">
        <table class="table table-responsive">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-left">Nama Item</th>
                <th class="text-center">Jml</th>
                <th class="text-right">Harga @</th>
                <th class="text-right">Jml Harga</th>
                <th class="text-right">Disc (%)</th>
                <th class="text-right">Harga Netto</th>
            </tr>
            <?php $i=1;?>
            @foreach($transaction->transaction_details as $transaction_detail)
                <?php $total = 0;$product = $transaction_detail->product;if (!$product) continue;$total += $transaction_detail->paid_price;?>
                <tr>
                    <td class="text-center">{{$i++}}</td>
                    <td class="text-left">{{$product->name}}</td>
                    <td class="text-center">{{$transaction_detail->amount}}</td>
                    <td class="text-right">{{number_format($product->price,null, ',','.')}},-</td>
                    <td class="text-right">{{number_format($transaction_detail->total_price,null, ',','.')}},-</td>
                    <td class="text-right">{{number_format($transaction_detail->total_discount,null, ',','.')}}</td>
                    <td class="text-right">{{number_format($transaction_detail->paid_price,null, ',','.')}},-</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="nota-total">
        <table class="table table-responsive">
            <tr>
                <td>Terbilang</td>
                <td>Seratus Delapan Puluh Dua Ribu Rupiah</td>
                <td colspan="2">Subtotal</td>
                <td class="text-center">Rp</td>
                <td class="text-right">{{number_format($total,null, ',','.')}}</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="4">&emsp;</td>
                <td>PPN</td>
                <td>0%</td>
                <td class="text-center">Rp</td>
                <td class="text-right">0.00</td>
            </tr>
            <tr>
                <td class="text-bold" colspan="2">Total</td>
                <td class="text-bold text-center">Rp</td>
                <td class="text-bold text-right">{{number_format($total,null, ',','.')}}</td>
            </tr>
            <tr>
                <td colspan="2">Ongkir</td>
                <td class="text-center">Rp</td>
                <td class="text-right">0.00</td>
            </tr>
            <tr>
                <td colspan="2">Biaya Lain</td>
                <td class="text-center">Rp</td>
                <td class="text-right">0.00</td>
            </tr>
            <tr>
                <td>Tanggal Cetak:</td>
                <td>{{date("d/m/Y H:i:s")}}</td>
                <td class="text-bold" colspan="2">Grand Total</td>
                <td class="text-bold text-center">Rp</td>
                <td class="text-bold text-right">{{number_format($total,null, ',','.')}}</td>
            </tr>
        </table>
    </div>
    <center>
        <div class="row">
            <div class="col-xs-3 text-center">
                <p>Dibuat Oleh,</p>
                <br><br><br>
                <p>(................................)</p>
            </div>
            <div class="col-xs-4 text-center">
                <p>Diperiksa Oleh,</p>
                <br><br><br>
                <p>(................................)</p>
            </div>
            <div class="col-xs-3 text-center">
                <p>Customer,</p>
                <br><br><br>
                <p>({{$user->name}})</p>
            </div>
        </div>
    </center>
</div>
</body>
</html>