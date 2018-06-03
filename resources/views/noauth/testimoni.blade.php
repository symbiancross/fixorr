@extends('layouts.app')

@section('content')
    <div class="container">
	<h1 class="mb-2 text-center">Testimoni</h1><br>
	<br>
	
	
		@if(count($sortedtukangs)>0)
		<form action="{{ route('urutkan') }}" method="GET">
        @csrf
		<div class="form-group row">
		<div class="col-1" style="margin-left: 190px;padding-right: 0px;">
		Urutkan:</div>
		<div class="col-2" style="padding-left: 0px;padding-right: 80px;margin-left: -20px;">
		<select name="urutkan" id="urutkan" class="form-control" >   
            <option value="1" @if(isset($selected) && $selected==1) selected @endif> Tertinggi </option>
            <option value="2" @if(isset($selected) && $selected==2) selected @endif> Terendah </option>
        </select>
    	</div>
    	<div class="col-5" style="padding-left: 25px;">
    		<button type="submit" class="btn btn-success" style="margin-left: -95px;">
                <i class="fa fa-btn fa-trash" ></i>Urutkan
            </button></div>
		</div>
		</form>

		
		@foreach($sortedtukangs as $sortedtukang)
		<div class="form-group row">

		<div class="col col-lg-2" style="margin-left: 190px;">
		<center><img src="{{ asset('image/'.$sortedtukang->tukang->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
	    </div>
		<div class="col">
	    
	    @for ($i = 0; $i < $sortedtukang->average; $i++)
	    <img src="{{ asset('images/star-on-big.png') }}">
	    @endfor
	    @for ($i = 0; $i < 5-$sortedtukang->average; $i++)
	    <img src="{{ asset('images/star-off-big.png') }}">
	    @endfor
	    <br>
        {{ $sortedtukang->tukang->nama }}<br>
        {{ $sortedtukang->keahlian }}<br>
    	</div>
        </div>
        @endforeach
	
	@endif
 </div> <!-- /container
@endsection
