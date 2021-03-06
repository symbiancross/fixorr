@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Konfirmasi Pemesanan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pesan.tukang.submit') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ $user->alamat }}" required autofocus>
                                    {!! $map['js'] !!}
                                    {!! $map['html'] !!}
                                
                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="biaya" class="col-md-4 col-form-label text-md-right">{{ __('Biaya*') }}</label>

                            <div class="col-md-6 col-form-label">
                                <input type="hidden" id="total" name="total" value="{{ $keahlian->biaya }}">
                                <input type="hidden" id="keahlian" name="keahlian" value="{{ $keahlian->keahlian_id }}">
                                <strong>Rp {{ number_format($keahlian->biaya,2,',','.') }}</strong>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deskripsi" class="col-md-4 col-form-label text-md-right">{{ __('Deskripsi Kerusakan') }}</label>

                            <div class="col-md-6">
                                <textarea id="deskripsi" name="deskripsi" placeholder="Tuliskan deskripsi kerusakan anda disini!" class="form-control"></textarea>
                                
                                @if ($errors->has('deskripsi'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('deskripsi') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }} row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Foto Kerusakan') }}</label>
                            
                            <div class="col-md-6">
                            <input type="file" class="form-control" name="photos[]" multiple />
                            </div>
                        </div>

                        <!-- Trigger the modal with a button -->
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal-{{ $keahlian->keahlian_id }}"> Pesan </button>

                            </div>
                        </div>

                        <br>
                        <center><small>*biaya merupakan murni ongkos tukang, belum termasuk material yang digunakan selama pengerjaan</small></center>

                        <!-- Modal -->
                        <div id="myModal-{{ $keahlian->keahlian_id }}" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              
                              <div class="modal-body">
                              
                                <div class="alert alert-success" role="alert">
                                
                                    <p>Silahkan menunggu, tukang kami akan menerima pesanan anda</p>
                                
                                </div>
                               
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                
                                <button type="submit" class="btn btn-success" onclick="$('#user-form-{{ $keahlian->keahlian_id }}').submit()">Ok</button>
                              </div>
                            </div>

                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection