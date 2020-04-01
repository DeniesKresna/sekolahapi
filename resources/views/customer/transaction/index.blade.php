@extends('layouts.guest')

@section('content')
    <style>
        .list-group-item{
            padding: 15px;
        }
        h3.list-group-item{
            font-size: 28px;
            font-weight: 600;
            color: orange;
        }
        .list-group > a.active,
        .list-group > a.active:link,
        .list-group > a.active:hover{
            color: yellow;
            background-color: darkgrey;
        }

        .history-code{
            font-family: "Fira Sans Medium";
            font-size: 15px;
        }
        .item-status-success{
            color: green;
            font-weight: 500;
        }
        .item-status-danger{
            color: red;
            font-weight: 500;
        }
        .item-status-default{
            color: darkgrey;
            font-weight: 500;
        }
        .history-date{
            color: grey;
        }
        .history-user h4{
            color: orange;
            font-size: 20px;
            font-weight: 600;
            padding: 10px;
        }
        .history-user{
            padding: 20px;
            margin-top: 20px;
        }
        a.detail-item-name:link,
        a.detail-item-name:hover,
        a.detail-item-name:active,
        a.detail-item-name:visited{
            text-decoration: none;
            background-color: transparent;
            color: #000;
        }
        .padd-left{
            padding-left: 12px;
        }
        .total-div{
            width: 300px;
        }


    </style>
    <div class="container">
        <div class="container-fluid text-center">
            <?php echo print_flashdata()?>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="list-group  bg-white">
                    <h3 class="list-group-item">Akun Profil</h3>
                    <a href="{{route("user.account")}}" class="list-group-item "><span class="glyphicon glyphicon-user"></span>&emsp;Akun Saya</a>
                    <a href="{{route("user.cart")}}" class="list-group-item"><span class="glyphicon glyphicon-shopping-cart"></span>&emsp;Isi Keranjang</a>
                    <a href="{{route("user.transaction")}}" class="list-group-item active"><span class="glyphicon glyphicon-gift"></span>&emsp;Riwayat Transaksi</a>
                    <a href="{{route("user.review")}}" class="list-group-item "><span class="glyphicon glyphicon-pencil"></span>&emsp;Ulasan Saya</a>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="bg-white history-user">
                    <h4>Riwayat Transaksi</h4>
                    <ul class="list-group list-history">
                        @if(sizeof($transactions)>0)
                            @foreach($transactions as $transaction)
                                <li class="list-group-item list-history-item">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <p class="history-code">Kode Transaksi - {{$transaction->id.strtotime($transaction->created_at)}}<br/><small><?php echo $transaction->status()?></small></p>
                                            <small class="history-date">{{date("d M Y H:i:s",strtotime($transaction->updated_at))}}</small>
                                        </div>
                                        <div class="col-xs-3">
                                            <p>melalui - {{$transaction->shop->name}}</p>
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Total: <b>Rp. {{number_format($transaction->count_price_product(),null,',','.')}},-</b></p>
                                        </div>
                                        <div class="col-xs-3">
                                            <a href="{{route("user.struct",["id"=>$transaction->id])}}" target="_blank"><button class="btn-link">Download Nota</button></a>
                                            <button class="btn-link" data-toggle="collapse" data-target="#{{$transaction->id.strtotime($transaction->created_at)}}">Detail</button>
                                        </div>
                                    </div>
                                    <div id="{{$transaction->id.strtotime($transaction->created_at)}}" class="collapse">
                                        <hr>
                                        <h4>Rincian Transaksi</h4>
                                        @if(sizeof($transaction->transaction_details)>0)
                                            @foreach($transaction->transaction_details as $detail)
                                                <div class="row detail-item padd-left">
                                                    <div class="col-xs-6">
                                                        <a href="{{route("user.product.detail",["id"=>$detail->id])}}" class="detail-item-name">{{$detail->product->name}}</a>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <p>Rp {{number_format($detail->original_price-($detail->original_price*$detail->total_discount/100),null, ',','.')}},- x ({{$detail->amount}})</p>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <p><b>Rp {{number_format($detail->paid_price,null, ',','.')}},-</b></p>
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
