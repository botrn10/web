@extends('frontend.layouts.app_frontend')
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
              
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row" style="background-color: white;">
            <div class="col-lg-12 mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Nạp tiền</h2>
                    <a href="/" class="btn btn-primary">Trở về</a>
                </div>
            </div>
            <div class="col-lg-12 mt-2">
                <form method="POST" id="alert_form_submit" action="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <label for="">Số tiền</label>
                        <input type="number" name="total_money" placeholder="Số tiền lớn hơn 10.000" class="form-control"
                            value="{{ old('total_money', $product->price ?? '') }}">
                        @error('total_money')
                            <small id="emailHelp" class="form-text text-danger">{{ $errors->first('total_money') }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Tiếp tục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
