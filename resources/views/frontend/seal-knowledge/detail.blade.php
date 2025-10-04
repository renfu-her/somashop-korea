@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">홈</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('seal-knowledge.index') }}">인장 이해</a></li>
                            <li class="breadcrumb-item active">{{ $knowledge->title }}</li>
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
                        @foreach($categories as $category)
                            <li class="nav-item">
                                <a class="nav-link {{ $currentCategory->id == $category->id ? 'active' : '' }}" 
                                   href="{{ route('seal-knowledge.index', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <section class="col-md-9 col-sm-12">
                    <div class="page-content">
                        <div class="page-title mb-4">
                            <h2 class="d-inline-block text-black text-left font-weight-bold">왜 온라인에서 도장이 이렇게 저렴할까요? 컴퓨터 각인과 수공예 각인의 차이점은?
                            </h2>
                            <span class="p-t14 text-gold">2020-07-29</span>
                        </div>

                        <div class="editor">
                            <p><span style="font-size:14px">많은 분들이 이런 의문을 가지고 계실 것입니다.</span><span style="color:#e67e22"><span
                                        style="font-size:18px">「왜 도장 가격이 이렇게 다양할까요?」</span></span><br />
                                <span style="font-size:14px">같은 재질의 도장과 각인인데, 어떤 것은 $100만 하면 되지만 어떤 것은 $3,4000, 심지어 만원 이상도 있습니다!!&nbsp;<br />
                                    마찬가지로 인기 있는 질문입니다.</span><span style="color:#e67e22"><span
                                        style="font-size:18px">「왜 어떤 도장은 1-2시간이면 픽업할 수 있는데, 어떤 것은 1-2개월이 걸릴까요?」</span></span><br />
                                <span style="font-size:14px">어떤 것은 순수 수공예 각인을 내세우고,<br />
                                    어떤 것은 컴퓨터 각인을 내세우는데,<br />
                                    차이점이 무엇일까요?</span>
                            </p>

                            <p><span style="font-size:14px">이렇게 예를 들어보겠습니다.<br />
                                    도장을 사용할 때 이런 상황을 겪어보신 적이 있을 것입니다.<br />
                                    바로</span><span style="color:#2980b9"><span
                                        style="font-size:16px">종이에 찍을 때 자주 선명하지 않아서,</span></span><span
                                    style="font-size:14px">많은 종이나 받침대가 필요하죠?</span></p>

                            <p><span style="font-size:14px">사실, 어떤 장인들이 만든 도장은</span><span style="font-size:18px"><span
                                        style="color:#e67e22">받침대도 필요 없고, 두꺼운 종이도 필요 없이</span></span><span
                                    style="font-size:14px">아름답게 찍을 수 있습니다!!!</span></p>

                            <p><span style="color:#c0392b"><span style="font-size:22px">이것이 바로 기술입니다!!! 그래서 가격에 차이가 있는 것입니다.</span></span></p>

                            <p>&nbsp;</p>

                            <p><span style="color:#2980b9"><span style="font-size:18px">【컴퓨터 각인】</span></span></p>

                            <p><span style="font-size:18px">장점: <span style="color:#2980b9">속도가 빠르고</span>, 각인 절단면이 일정합니다.</span></p>

                            <p><span style="font-size:18px">단점: 각인된 글자가 <span style="color:#2980b9">고물 같고 생동감이 없습니다</span>.</span>
                            </p>

                            <p>&nbsp;</p>

                            <p><span style="color:#e67e22"><span style="font-size:18px">【수공예 각인】</span></span></p>

                            <p><span style="font-size:18px">장점: 수동 레이아웃으로, 글자체 스타일을 <span
                                        style="color:#e67e22">가장 빠르게 조정</span>할 수 있습니다.</span></p>

                            <p><span style="font-size:18px">단점: <span style="color:#e67e22">시간과 노력이 많이 들고</span>, 인문 하단에 톱니 모양이 생깁니다.</span>
                            </p>

                            <p>&nbsp;</p>

                            <p><span style="font-size:22px"><span style="color:#c0392b">보베인은 독점적인</span><u><a
                                            href="https://www.babyin.tw/article.php?c=2&amp;p=18"><span
                                                style="color:#2980b9">【</span></a></u><a
                                        href="https://www.babyin.tw/article.php?c=2&amp;p=18"><span
                                            style="color:#2980b9">거울면 고정각공】</span></a></span><a
                                    href="https://www.babyin.tw/article.php?c=2&amp;p=18"><span style="font-size:14px"><span
                                            style="color:#e67e22">(클릭해서 보기)</span></span></a></p>

                            <p><span style="font-size:22px"><span style="color:#c0392b">유리 표면에 직접 인쇄할 수 있으며, 좋은 재료와 정교한 각인을 고집합니다</span></span>
                            </p>
                        </div>
                    </div>


                    <nav class="my-5" aria-label="Page navigation">
                        <div class="pagination justify-content-center">
                            <button class="btn btn-light btn-page rounded border" onclick="history.back()"
                                value="목록으로">목록으로</button>
                        </div>
                    </nav>
                </section>
            </div>
        </div>
    </article>
@endpush
