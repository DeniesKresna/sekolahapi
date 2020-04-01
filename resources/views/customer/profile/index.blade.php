@extends('layouts.guest')

@section('content')
    <div class="bg-grey">
        <div class="container" id="profile">
            <div class="row">
                <div class="col-sm-8 bg-white margin-side panel panel-default">
                    <div class="profile-data panel-body">
                        <a type="button" data-toggle="modal" data-target="#editProfileModal" class="btn btn-white text-right">edit profil</a>

                        <table>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>:</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>:</td>
                                <td>{{$user->birth_place}}, {{date("d M Y", strtotime($user->birth_date))}}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td>{{$user->address}}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>:</td>
                                <td>{{$user->phone}}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>:</td>
                                <td>{{$user->current_job}}</td>
                            </tr>
                            <tr>
                                <th>NIM / NPM</th>
                                <td>:</td>
                                <td>{{$user->student_id_number}}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>:</td>
                                <td>{{$user->religion}}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>:</td>
                                <td>{{$user->gender}}</td>
                            </tr>
                            <tr>
                                <th>Status Pernikahan</th>
                                <td>:</td>
                                <td>{{$user->marriage_status}}</td>
                            </tr>
                            <tr>
                                <th>Nomor KTP</th>
                                <td>:</td>
                                <td>{{$user->identity_card_number}}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan/Jurusan</th>
                                <td>:</td>
                                <td>{{$user->education}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-sm-3 bg-white margin-side panel panel-default">
                    <div class="profile-pass panel-body">
                        <p>Email:<br>{{$user->email}}</p>
                        <p>Password:<br>********</p>
                        <p><a type="button" class="btn-white" data-toggle="modal" data-target="#editPass">ubah Password</a></p>
                        <p><a href="{{route("submission")}}">Riwayat Pengajuan</a></p>
                        <p><a href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();" >Log out</a></p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile modal -->
        <div class="modal fade" id="editProfileModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Akun Profil</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="{{route('user.account.update')}}" method="post">
                            <div class="form-group">
                                <label class="control-label col-sm-3">Nama Lengkap:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" name="name" type="text" placeholder="Nama Lengkap" value="{{$user->name}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-xs-12">Tempat & Tanggal Lahir:</label>
                                <div class="col-sm-5 col-xs-6">
                                    <input class="form-control" type="text" name="birth_place" placeholder="Kota Lahir" value="{{$user->birth_place}}" required>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <input class="form-control" type="date" name="birth_date" value="{{$user->birth_date}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Alamat:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="2" name="address" placeholder="Alamat" required>{{$user->address}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">No. Telepon:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" name="phone" placeholder="No. Telepon" value="{{$user->phone}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Pekerjaan:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="current_job" placeholder="Pekerjaan" value="{{$user->current_job}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">NIM / NPM:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" name="student_id_number" placeholder="NIM / NPM" value="{{$user->student_id_number}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Agama:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="religion" required>
                                        <option>-- Pilih Agama Kepercayaan --</option>
                                        <option value="Islam"  @if($user->religion == "Islam") selected @endif>Islam</option>
                                        <option value="Kristen"  @if($user->religion == "kristen") selected @endif>Kristen</option>
                                        <option value="Katolik"  @if($user->religion == "Katolik") selected @endif>Katolik</option>
                                        <option value="Hindu"  @if($user->religion == "Hindu") selected @endif>Hindu</option>
                                        <option value="Buddha"  @if($user->religion == "Buddha") selected @endif>Buddha</option>
                                        <option value="Khong Hu Chu"  @if($user->religion == "Khong Hu Chu") selected @endif>Khong Hu Chu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Jenis Kelamin:</label>
                                <div class="col-sm-9">
                                    <label class="radio-inline"><input type="radio" value="laki laki" @if($user->gender == "laki laki") checked @endif name="gender">Laki-laki</label>
                                    <label class="radio-inline"><input type="radio" value="perempuan" @if($user->gender == "perempuan") checked @endif name="gender">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Agama:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="marriage_status" required>
                                        <option >-- Pilih Status Pernikahan --</option>
                                        <option value="Belum Menikah"  @if($user->marriage_status == "Belum Menikah") selected @endif>Belum Menikah</option>
                                        <option value="Menikah"  @if($user->marriage_status == "Menikah") selected @endif>Menikah</option>
                                        <option value="Cerai Hidup"  @if($user->marriage_status == "Cerai Hidup") selected @endif>Cerai Hidup</option>
                                        <option value="Cerai Mati"  @if($user->marriage_status == "Cerai Mati") selected @endif>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Nomor KTP:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" value="{{$user->identity_card_number}}" placeholder="Nomor KTP" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3">Pendidikan / Jurusan:</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="{{$user->education}}" placeholder="Pendidikan / Jurusan" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-md btn-green">Ubah</button>
                                    <button type="reset" class="btn btn-md btn-white">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- password modal -->
        <div class="modal fade" id="editPass" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ubah Password</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal"  action="{{route('user.account.password')}}" method="post">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Password Lama:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="password" name="old_password" placeholder="Password Lama" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Password baru:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="password" placeholder="Password Baru" name="new_password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4">Re-Enter Password Baru:</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="password" placeholder="Re-Enter Password Baru" name="password_confirm" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" class="btn btn-md btn-green">Daftar</button>
                                    <button type="reset" class="btn btn-md btn-white">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

