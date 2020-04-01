<link href="{{asset("public/css/custom.css")}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">
<div id="statement">
    <h1><u><strong>SURAT PERNYATAAN</strong></u></h1>
    <p>   Yang bertanda tangan di bawah ini:</p>
    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?php echo (isset($user->name))?$user->name:"Tidak ada nama"?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo (isset($user->address))?$user->address:"Tidak ada alamat"?></td>
        </tr>
        <tr>
            <td>Bidang</td>
            <td>:</td>
            <td><?php echo (isset($result->research_field))?$result->research_field:"Tidak ada bidang"?></td>
        </tr>
    </table>
    <p class="text-justify">   Dengan ini menyatakan bahwa saya bersedia untuk mentaati dan tidak melanggar ketentuan peraturan perundang-undangan yang berlaku selama melakukan kegiatan penelitian.</p>
    <p class="text-justify">   Demikian surat pernyataan ini saya buat tanpa ada unsur paksaan dan penuh rasa tanggung jawab.</p>
    <br><br>
    <div id="statementSign">
        <p>Madiun, {{date("d M Y")}}</p>
        <p>Yang menyatakan</p>
        <br><br><br>
        <p><?php echo (isset($user->name))?$user->name:"Tidak ada nama"?></p>
    </div>
</div>
<style>
    #statement{font-family: 'Roboto', sans-serif;margin: 15px 30px;}
    #statement h1{text-align: center;font-size: 30px;}
    #statement table{width: 100%;}
    #statementSign{float: right;margin-right: 20px;}
</style>
