@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">자주 묻는 질문</li>
                            <li class="breadcrumb-item active" aria-current="page">
                                @foreach($categories as $category)
                                    @if($categoryId == $category->id)
                                        {{ $category->title }}
                                    @endif
                                @endforeach
                            </li>
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
                                <a class="nav-link mb-2 {{ $categoryId == $category->id ? 'active' : '' }}"
                                    href="{{ route('faqs.index', $category->id) }}">
                                    {{ $category->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <section class="col-md-9 col-sm-12">
                    <div class="page-content">
                        <div class="page-title">
                            <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up"
                                data-aos-delay="150">자주 묻는 질문</h2>
                            <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="300">Q & A</h4>
                        </div>

                        <div class="faq accordion" id="faqAccordion">
                            @foreach ($faqs as $index => $faq)
                                <div class="card mb-3" data-aos="zoom-in-up" data-aos-delay="{{ 500 + $index * 100 }}"
                                    data-aos-anchor-placement="top-bottom" data-aos-once="true">
                                    <div class="card-header" id="heading{{ $index }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link collapsed d-flex align-items-center" type="button"
                                                data-toggle="collapse" data-target="#faq{{ $index }}"
                                                aria-expanded="false" aria-controls="faq{{ $index }}">
                                                <i class="fas fa-question-circle pr-2"></i>
                                                {{ $faq->title }}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="faq{{ $index }}" class="collapse"
                                        aria-labelledby="heading{{ $index }}" data-parent="#faqAccordion">
                                        <div class="card-body">
                                            {!! $faq->content !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <nav class="my-5" aria-label="Page navigation">
                        <ul class="pagination justify-content-center" style="display:none;">
                            <li class="page-item">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-page border dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown">
                                        1 </button>
                                    <div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <a class="dropdown-item" href="faq.php?c=7&p=1">1</a>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </nav>

                </section>


            </div>
        </div>
    </article>
@endpush
