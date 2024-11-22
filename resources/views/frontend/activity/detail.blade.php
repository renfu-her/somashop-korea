@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="{{ route('activity.index') }}">活動訊息</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $activity->title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <!-- Page Content Start -->
    <article class="page-wrapper my-3">
        <div class="container">
            <div class="page-title">
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up">{{ $activity->title }}<small
                        class="d-inline-block p-t14 text-gold mb-md-3 mb-3 px-2">{{ $activity->date->format('Y-m-d') }}</small>
                </h2>
                <p class="text-center mb-4" data-aos="zoom-in-up" data-aos-delay="150">{{ $activity->subtitle }}</p>
            </div>

            <div class="row">
                <div class="col-12">
                    <img src="{{ asset('storage/activities/' . $activity->id . '/' . $activity->image) }}"
                        class="img-fluid activity-detail-image" style="max-width: 100%;">
                </div>
            </div>

            <section class="my-5" data-aos="zoom-in" data-aos-delay="450">
                {!! $activity->content !!}
            </section>

            {{-- <nav class="my-5 d-md-block d-none">
                <ul class="pager">


                    <li class="pager-item">
                        <a href="act_center.php?p=62" class="anime-down">
                            <i class="fas fa-chevron-down text-danger"></i>
                            <span class="mx-3">下一則</span>
                            <span>免費剃胎毛儀式活動開跑囉!</span>
                        </a>
                    </li>
                </ul>
            </nav> --}}

            <nav class="my-5" aria-label="Page navigation">
                <div class="pagination justify-content-center">
                    <a class="btn btn-light btn-page rounded border" href="{{ route('activity.index') }}"
                        value="回列表">回列表</a>
                </div>
            </nav>

        </div>
    </article>
@endpush
