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
                            <h2 class="d-inline-block text-black text-left font-weight-bold">為什麼網路上的印章這麼便宜？電腦篆刻、手工篆刻 差在哪裡？
                            </h2>
                            <span class="p-t14 text-gold">2020-07-29</span>
                        </div>

                        <div class="editor">
                            <p><span style="font-size:14px">一定有很多人有這個疑問，</span><span style="color:#e67e22"><span
                                        style="font-size:18px">「為甚麼印章價格阿那麼多？」</span></span><br />
                                <span style="font-size:14px">明明相同材質的印章含刻印，有些做只要$100，但有些卻要$3、4000，甚至上萬都有!!&nbsp;<br />
                                    同樣是熱門問題，</span><span style="color:#e67e22"><span
                                        style="font-size:18px">「為甚麼印章有些1小時2小時就可以取貨，但有些卻要一兩個月？」</span></span><br />
                                <span style="font-size:14px">有些標榜著純手工的刻，<br />
                                    有些標榜著電腦的篆刻，<br />
                                    又差在哪裡呢?</span>
                            </p>

                            <p><span style="font-size:14px">這樣舉例好了<br />
                                    相信大家在使用印章時都有遇過一種情況<br />
                                    就是</span><span style="color:#2980b9"><span
                                        style="font-size:16px">蓋在紙上常常蓋不清楚，</span></span><span
                                    style="font-size:14px">面都要但好多紙或著墊子吧?</span></p>

                            <p><span style="font-size:14px">其實吧，有些師傅刻出來的印章，下面是</span><span style="font-size:18px"><span
                                        style="color:#e67e22">完全不需要墊子，也不需要墊一層厚厚的紙，就可以蓋得很漂亮了</span></span><span
                                    style="font-size:14px">!!!</span></p>

                            <p><span style="color:#c0392b"><span style="font-size:22px">這就是工!!!所以價格才會有所差異。</span></span></p>

                            <p>&nbsp;</p>

                            <p><span style="color:#2980b9"><span style="font-size:18px">【電腦篆刻】</span></span></p>

                            <p><span style="font-size:18px">優點：<span style="color:#2980b9">速度快</span>，篆刻切面粗細一致。</span></p>

                            <p><span style="font-size:18px">缺點：刻出來的字，<span style="color:#2980b9">像個老古董，不那麼生動</span>。</span>
                            </p>

                            <p>&nbsp;</p>

                            <p><span style="color:#e67e22"><span style="font-size:18px">【手工篆刻】</span></span></p>

                            <p><span style="font-size:18px">優點：人工排版，字體樣式都<span
                                        style="color:#e67e22">可以做最快速的調整</span>。</span></p>

                            <p><span style="font-size:18px">缺點：<span style="color:#e67e22">費時費力</span>，印文底部會有一齒一齒的形狀。</span>
                            </p>

                            <p>&nbsp;</p>

                            <p><span style="font-size:22px"><span style="color:#c0392b">寶貝印有獨家的</span><u><a
                                            href="https://www.babyin.tw/article.php?c=2&amp;p=18"><span
                                                style="color:#2980b9">【</span></a></u><a
                                        href="https://www.babyin.tw/article.php?c=2&amp;p=18"><span
                                            style="color:#2980b9">鏡面古井刻工】</span></a></span><a
                                    href="https://www.babyin.tw/article.php?c=2&amp;p=18"><span style="font-size:14px"><span
                                            style="color:#e67e22">(點我看介紹)</span></span></a></p>

                            <p><span style="font-size:22px"><span style="color:#c0392b">能直接拓印於玻璃表面，堅持用好材料、刻好印章</span></span>
                            </p>
                        </div>
                    </div>


                    <nav class="my-5" aria-label="Page navigation">
                        <div class="pagination justify-content-center">
                            <button class="btn btn-light btn-page rounded border" onclick="history.back()"
                                value="回列表">回列表</button>
                        </div>
                    </nav>
                </section>
            </div>
        </div>
    </article>
@endpush
