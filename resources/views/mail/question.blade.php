
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
<h1>Seseorang menanyakan sesuatu pada tanggal {{date("d M Y H:i:s")}}</h1>
<table>
    <tr>
        <td>Nama</td><td>:</td><td>{{$data->name}}</td>
    <tr>
        <td>Email</td><td>:</td><td>{{$data->email}}</td>
    </tr>
    <tr>
        <td>Telepon/WA</td><td>:</td><td>{{$data->phone}}</td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td>{{$data->address}}</td>
    </tr>
    <tr>
        <td>Pertanyaan</td><td>:</td><td>{{$data->question}}</td>
    </tr>
    </tr>
</table>