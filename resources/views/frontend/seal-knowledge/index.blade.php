@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">홈</a></li>
                            <li class="breadcrumb-item">인장 이해</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $currentCategory->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content Start -->
    <article class="page-wrapper my-3">
        <div class="container">
            <div class="row">
                <aside class="sidebar col-md-3">
                    <ul class="nav flex-column">
                        @foreach ($categories as $category)
                            <li class="nav-item">
                                <a class="nav-link {{ $currentCategory->id == $category->id ? 'active' : '' }}"
                                    href="{{ route('seal-knowledge.category', $category->id) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <section class="col-md-9 col-sm-12">
                    <div class="page-content">
                        <div class="page-title">
                            <h2 class="text-black text-center font-weight-bold mb-4" data-aos="zoom-in-up"
                                data-aos-delay="150">{{ $currentCategory->name }}</h2>
                        </div>

                        <!-- 20200724 updated-->
                        <div class="list-group-row">
                            <ul class="list-unstyled">
                                @foreach ($knowledges as $knowledge)
                                    <li data-aos="zoom-in-up" data-aos-delay="{{ 500 + $loop->index * 100 }}"
                                        data-aos-anchor-placement="top-bottom" data-aos-once="true">
                                        <a href="{{ route('seal-knowledge.show', $knowledge->id) }}">
                                            <span class="pr-3">{{ $knowledge->created_at->format('Y-m-d') }}</span>
                                            {{ $knowledge->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- 20200724 updated-->

                    <nav class="my-5" aria-label="Page navigation">
                        {{ $knowledges->links() }}
                    </nav>
                </section>
            </div>
        </div>
    </article>
@endpush
