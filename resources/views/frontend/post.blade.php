@extends('frontend.layouts.app')

@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">品牌故事</li>
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

                        <!-- ********************* editor start here ********************* -->



                        <p><img alt="" src="https://babyin.tw/uploads/c9c9a07dc945572b34a219ab158fd7ab.png"
                                style="width:100%" class="img-fluid"></p>

                        <p><img alt="" src="http://babyin.tw/uploads/7bd11bca30e22f9b8ec534cc61a377be.jpg"
                                class="img-fluid"></p>

                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <p><img alt="" src="https://babyin.tw/uploads/2abc6a9747be36c1fd39eeb9b51f83e1.jpg"
                                style="width:100%" class="img-fluid"></p>

                        <p>&nbsp;</p>

                        <p>&nbsp;</p>

                        <p>&nbsp;</p>


                        <!-- ********************* editor end here ********************* -->

                    </div>
                </section>
            </div>
        </div>
    </article>
@endsection
