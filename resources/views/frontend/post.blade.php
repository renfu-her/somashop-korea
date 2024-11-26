@extends('frontend.layouts.app')

@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $postTitle }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <article class="page-wrapper my-3">
        <div class="container">
            <div class="row">
                <aside class="sidebar col-md-3">
                    <ul class="nav flex-column">
                        @foreach ($posts as $post)
                            <li class="nav-item mb-2">
                                <a class="nav-link active"
                                    href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                            </li>
                        @endforeach

                    </ul>
                </aside>
                <section class="col-md-9 col-sm-12">
                    <div class="page-content">
                        {!! $postContent !!}
                    </div>
                </section>
            </div>
        </div>
    </article>
@endsection

@push('styles')
    <style>
        .page-content img {
            max-width: 100%;
        }
    </style>
@endpush
