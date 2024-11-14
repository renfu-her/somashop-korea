@extends('frontend.layouts.app')

@push('app-content')
    <article class="page-wrapper my-3">
        <div class="container">

            <div class="page-banner text-center">

                <img src="{{ asset('assets/images/8d32ef5aa88750ffb21f6e413403284d.jpg') }}" class="img-fluid">

            </div>
            <section>
                <div class="row">


                    <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-1 pr-2 aos-init aos-animate" data-aos="zoom-in"
                        data-aos-delay="0" data-aos-anchor-placement="top-bottom">
                        <a href="act_center.php?p=69">
                            <div class="card border-0">
                                <img class="card-img-top img-fluid" src="uploads/8f3848c868b9d40de45f699b841a2687.jpg"
                                    alt="">
                                <div class="card-body px-0">
                                    <p class="card-text mb-1"><small class="text-gold">2020-09-03</small></p>
                                    <h5 class="card-title text-dark">刻印章開財運</h5>
                                    <p class="card-text">你想財富雙收嗎? 你想輕鬆招財嗎?</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-1 pr-2 aos-init aos-animate" data-aos="zoom-in"
                        data-aos-delay="150" data-aos-anchor-placement="top-bottom">
                        <a href="act_center.php?p=62">
                            <div class="card border-0">
                                <img class="card-img-top img-fluid" src="uploads/8b8e4eb7b6e95b6350e23a8417b93f19.jpg"
                                    alt="">
                                <div class="card-body px-0">
                                    <p class="card-text mb-1"><small class="text-gold">2019-08-12</small></p>
                                    <h5 class="card-title text-dark">免費剃胎毛儀式活動開跑囉!</h5>
                                    <p class="card-text">來門市做臍帶印章免費送古禮儀式剃胎毛唷 (限門市)</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-1 pr-2 aos-init aos-animate" data-aos="zoom-in"
                        data-aos-delay="300" data-aos-anchor-placement="top-bottom">
                        <a href="act_center.php?p=34">
                            <div class="card border-0">
                                <img class="card-img-top img-fluid" src="uploads/am_01.png" alt="">
                                <div class="card-body px-0">
                                    <p class="card-text mb-1"><small class="text-gold">2018-12-26</small></p>
                                    <h5 class="card-title text-dark">溫馨剃胎毛古禮儀式</h5>
                                    <p class="card-text">全程使用消毒過的安全電剪喔，不傷頭皮，不刮寶寶頭皮</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-1 pr-2 aos-init" data-aos="zoom-in"
                        data-aos-delay="450" data-aos-anchor-placement="top-bottom">
                        <a href="act_center.php?p=44">
                            <div class="card border-0">
                                <img class="card-img-top img-fluid" src="uploads/am_03.png" alt="">
                                <div class="card-body px-0">
                                    <p class="card-text mb-1"><small class="text-gold">2018-02-18</small></p>
                                    <h5 class="card-title text-dark">年節過後 開戶最佳時機</h5>
                                    <p class="card-text">媽媽我要趕快把樂樂的壓歲錢存起來，小樂樂今年過年真是大豐收呀，手裡握</p>
                                </div>
                            </div>
                        </a>
                    </div>

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
