
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
<h1>Informasi Pemesanan Pelanggan</h1>
<p>Pelanggan anda telah melakukan pembatalan pemesanan. Berikut list pesanan :</p>
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
    </div>
    <div id="{{$transaction->id.strtotime($transaction->created_at)}}">
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
