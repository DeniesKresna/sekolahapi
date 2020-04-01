<link href="{{asset("public/css/custom.css")}}?<?php echo time(); ?>" rel="stylesheet" type="text/css">
<div id="subFile">
    <div class="letterhead">
        <table>
            <tr>
                <td><img src="{{asset("public/gallery/material/city_logo.jpg")}}" style="width: 100px"></td>
                <td>
                    <h3>PEMERINTAH KOTA MADIUN</h3>
                    <h2>BADAN KESATUAN BANGSA DAN POLITIK</h2>
                    <p>GEDUNG KRIDA PRAJA LANTAI III</p>
                    <p>JL. D.I. PANJAITAN NO.17 KOTA MADIUN</p>
                    <p>TELEPON (0351) 462153</p>
                    <p>website : http://www.madiunkota.go.id</p>
                </td>
            </tr>
        </table>
    </div>
    <div id="subData">
        <h3><u>DATA PRIBADI</u></h3>
        <table>
            <tr>
                <td>1. NAMA LENGKAP</td>
                <td>:</td>
                <td>{{$result->user->name}}</td>
            </tr>
            <tr>
                <td>2. TEMPAT DAN TANGGAL LAHIR</td>
                <td>:</td>
                <td>{{$result->user->birth_place.", ".date("d M Y",strtotime($result->user->birth_date))}}</td>
            </tr>
            <tr>
                <td>3. ALAMAT DAN NOMOR TELEPON</td>
                <td>:</td>
                <td>{{$result->user->address.", ".$result->user->phone }}</td>
            </tr>
            <tr>
                <td>4. PEKERJAAN</td>
                <td>:</td>
                <td>{{$result->user->current_job}}</td>
            </tr>
            <tr>
                <td>5. NIM / NPM</td>
                <td>:</td>
                <td>{{$result->user->student_id_number }}</td>
            </tr>
            <tr>
                <td>6. AGAMA</td>
                <td>:</td>
                <td>{{$result->user->religion }}</td>
            </tr>
            <tr>
                <td>7. JENIS KELAMIN</td>
                <td>:</td>
                <td>{{$result->user->gender }}</td>
            </tr>
            <tr>
                <td>8. STATUS PERNIKAHAN</td>
                <td>:</td>
                <td>{{$result->user->marriage_status }}</td>
            </tr>
            <tr>
                <td>9. NOMER KTP</td>
                <td>:</td>
                <td>{{$result->user->identity_card_number }}</td>
            </tr>
            <tr>
                <td>10. PENDIDIKAN / JURUSAN</td>
                <td>:</td>
                <td>{{$result->user->education }}</td>
            </tr>
            <tr>
                <td>11. JUDUL PENELITIAN/SKRIPSI/THESIS</td>
                <td>:</td>
                <td>{{$result->title }}</td>
            </tr>
            <tr>
                <td>12. TEMPAT SURVEY/RISET<!-- <br>(KANTOR/DINAS/NSTANSI/LEMBAGA/PERUSAHAAN) --></td>
                <td>:</td>
                <td>
                    @foreach(to_object($result->get_survey_sites()) as $survey_site)
                        {{$survey_site->name}}<br/>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>13. LAMA SURVEY</td>
                <td>:</td>
                <td>{{$result->survey_deadline }}</td>
            </tr>
            <tr>
                <td>14. PESERTA PENELITIAN</td>
                <td>:</td>
                <td>
                    @foreach(json_decode($result->research_participants) as $research_participant)
                        {{$research_participant}}<br/>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>15. TUJUAN PENELITIAN</td>
                <td>:</td>
                <td>{{$result->research_purposes }}</td>
            </tr>
        </table>
    </div>
    <br><br>
    <div id="subSign">
        <p>MADIUN, {{date("d M Y")}}</p>
        <p>PEMOHON</p>
        <br><br><br>
        <p>{{$result->user->name}}</p>
    </div>
</div>
