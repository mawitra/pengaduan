@extends('layouts.admin')

@section('content')
    
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>History Pengaduan</h3>
                    <p class="text-subtitle text-muted">For history to check they lists</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">History Pengaduan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="" class="btn btn-success">Export</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Tgl Pengaduan</th>
                                <th>Petugas</th>
                                <th>NIK</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Laporan</th>
                                <th>Tanggapan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                            ?>
                            @foreach($pengaduan as $item)
                            <?php
                                $tanggapan = DB::table('tanggapan')->where('id_pengaduan', $item->id)->get();
                                $id_user = DB::table('users')->where('id', $item->id_user)->get();
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="{{ asset('uploads/'.$item->foto) }}" width="100" height="100" alt=""></td>
                                <td>{{ $item->tgl_pengaduan }}</td>
                                @foreach($tanggapan as $value)
                                    <?php
                                        $user = DB::table('users')->where('id', $value->id_petugas)->get();
                                    ?>
                                    
                                    @foreach($user as $row)
                                        <td>{{ $row->name }}</td>
                                    @endforeach

                                    @foreach($id_user as $row2)
                                        <td>{{ $row2->nik }}</td>
                                        <td>{{ $row2->name }}</td>
                                    @endforeach

                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->isi_laporan }}</td>
                                    <td>{{ $value->tanggapan }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>

</div>

@endsection