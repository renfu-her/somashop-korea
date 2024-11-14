@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a
                                    href="product_list.php?c=14">胎毛肚臍章、開運章</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="product_list.php?c=14">南非赤牛角</a>
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
                <aside class="sidebar col-md-3 pl-0 pr-5">
                    <div class="accordion" id="accordionLeftMenu">
                        @component('frontend.components.category-menu-item', [
                            'categories' => $categories,
                            'currentCategory' => $currentCategory,
                        ])
                        @endcomponent
                    </div>
                </aside>

                <section class="col-lg-9 col-md-12 col-12">
                    <div class="page-content">
                        <div class="row">

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0"
                                data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=36">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/25e3b8c28f2ac5bf2b466f532de18631.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">A級南非赤牛角-平裝(單印)</h5>
                                            <p class="card-text">嚴選天然優質赤牛角， 質地溫潤、堅毅、耐用。</p>
                                            <h6 class="card-text">原價 NT$ 4,400</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 3,800</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0"
                                data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=40">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/13b09cded1b1a38624bb45bbb589bfd4.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">A級南非赤牛角-精裝(單印)</h5>
                                            <p class="card-text">嚴選天然優質赤牛角， 質地溫潤、堅毅、耐用。</p>
                                            <h6 class="card-text">原價 NT$ 5,200</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 4,200</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0"
                                data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=111">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/d1dfb59eeda361fd953c73f6fd7482cd.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">精裝版 南非A級赤牛角珍藏單章印鑑組</h5>
                                            <p class="card-text">珍藏寶貝的每一刻</p>
                                            <h6 class="card-text">原價 NT$ 7,600</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 6,600</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0"
                                data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=37">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/6460d77afb8dd6e6d065c00a753cac01.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">A級南非赤牛角-平裝(雙印)</h5>
                                            <p class="card-text">嚴選天然優質赤牛角， 質地溫潤、堅毅、耐用。</p>
                                            <h6 class="card-text">原價 NT$ 8,600</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 7,600</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in" data-aos-delay="0"
                                data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=41">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/2c0012829f9e39defe0ffaa3fb9fc5ef.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">A級南非赤牛角-精裝(雙印)</h5>
                                            <p class="card-text">嚴選天然優質赤牛角， 質地溫潤、堅毅、耐用。</p>
                                            <h6 class="card-text">原價 NT$ 9,800</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 8,000</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in"
                                data-aos-delay="0" data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=119">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/e4b70db1c7089bf2a4d6ccec33cf9ec5.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">精裝版 南非A級赤牛角珍藏印鑑 雙章組</h5>
                                            <p class="card-text">渾然天成、獨一無二</p>
                                            <h6 class="card-text">原價 NT$ 11,400</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 10,400</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in"
                                data-aos-delay="0" data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=38">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/6f65db6c6cb72dbacd838c1be9c32999.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">S級南非赤牛角-平裝(單印)</h5>
                                            <p class="card-text">嚴選天然優質赤牛角， 質地溫潤、堅毅、耐用。 本店嚴選萬中挑一，如皇族鳳梨黃之透度，同象牙般白皙，晶透絕美!</p>
                                            <h6 class="card-text">原價 NT$ 14,700</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 12,400</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in"
                                data-aos-delay="0" data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=102">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/f364476af18db6f6662e4cd80a7cc5df.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">S級南非赤牛角-精裝(單印)</h5>
                                            <p class="card-text">本店嚴選萬中挑一</p>
                                            <h6 class="card-text">原價 NT$ 15,500</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 12,800</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 my-md-3 my-2 px-md-3 pl-2 pr-1" data-aos="zoom-in"
                                data-aos-delay="0" data-aos-anchor-placement="center-bottom">
                                <a href="product_content.php?c=14&p=39">
                                    <div class="card product-card border-0">
                                        <div class="card-top">
                                            <img src="./uploads/f81601ba2c96e556d952e98f93390d74.jpg"
                                                class="card-img-top img-fluid" alt="">
                                            <b class="float-tag text-white bg-danger">新品</b>
                                        </div>
                                        <div class="card-body px-0">
                                            <h5 class="card-title">S級南非赤牛角-平裝(雙印)</h5>
                                            <p class="card-text">嚴選天然優質赤牛角， 質地溫潤、堅毅、耐用。 本店嚴選萬中挑一，如皇族鳳梨黃之透度，同象牙般白皙，晶透絕美!</p>
                                            <h6 class="card-text">原價 NT$ 27,100</h6>
                                            <h5 class="card-text text-danger">現金價 NT$ 24,800</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <nav class="my-5" aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-page border dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown">
                                        1
                                    </button>
                                    <div class="page-menu dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <a class="dropdown-item" href="product_list.php?c=14&p=1">1</a>

                                        <a class="dropdown-item" href="product_list.php?c=14&p=2">2</a>
                                    </div>
                                </div>
                            </li>


                            <li class="page-item pl-3">
                                <a class="page-link rounded-circle" href="product_list.php?c=14&p=2">
                                    <i class="fas fa-chevron-right"></i>
                                    <span class="sr-only">下一頁</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </section>


            </div>
        </div>
    </article>
@endpush
