@extends('frontend.layouts.app')

@push('app-content')
    <article class="page-wrapper my-3">
        <div class="container">
            <section>
                <div class="row">

                    @foreach ($activities as $activity)
                        <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-1 pr-2 aos-init aos-animate" data-aos="zoom-in"
                            data-aos-delay="0" data-aos-anchor-placement="top-bottom">
                            <a href="{{ route('activity.detail', $activity->id) }}">
                                <div class="card border-0">
                                    <img class="card-img-top img-fluid activity-card-image"
                                        src="{{ asset('storage/activities/' . $activity->id . '/' . $activity->image) }}"
                                        alt="">
                                    <div class="card-body px-0">
                                        <p class="card-text mb-1"><small
                                                class="text-gold">{{ $activity->date->format('Y-m-d') }}</small></p>
                                        <h5 class="card-title text-dark">{{ $activity->title }}</h5>
                                        <p class="card-text">{{ $activity->subtitle }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            <nav class="my-5" aria-label="Page navigation">
                <ul class="pagination justify-content-center" style="display:none;">
                    <li class="page-item">
                        <div class="dropdown">
                            <button class="btn btn-light btn-page border dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown">
                                1
                            </button>
                            <div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="act_list.php?page=1">1</a>
                            </div>
                        </div>
                    </li>

                </ul>
            </nav>

        </div>
    </article>
@endpush

@push('styles')
    <style>
        .activity-card-image {
            aspect-ratio: 1/0.8;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endpush
