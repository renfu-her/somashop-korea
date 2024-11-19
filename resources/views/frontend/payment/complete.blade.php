@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">付款結果</div>
                <div class="card-body text-center">
                    @if($success)
                        <h3 class="text-success">付款成功</h3>
                    @else
                        <h3 class="text-danger">付款失敗</h3>
                    @endif
                    <p>{{ $message }}</p>
                    <p>訂單編號：{{ $orderNumber }}</p>
                    <a href="{{ route('index') }}" class="btn btn-primary">返回首頁</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 