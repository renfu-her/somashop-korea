@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="./">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">加入會員</li>
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
                <h2 class="text-black text-center font-weight-bold mb-0" data-aos="zoom-in-up" data-aos-delay="450">加入會員
                </h2>
                <h4 class="text-center text-gold mb-4" data-aos="zoom-in-up" data-aos-delay="600">Join Member</h4>
                <hr class="page_line" data-aos="flip-right" data-aos-delay="0" data-aos-duration="3000">
            </div>

            <section data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="750" data-aos-offset="0">
                <div class="row justify-content-center py-3">
                    <div class="col-md-7 col-sm-12 my-3">
                        <form method="post" action="proc.php?proc=join" enctype="multipart/form-data"
                            onsubmit="return checkform();">
                            <div class="form-group row mb-3">
                                <label for="inputEmail"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>電子郵件 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="inputEmail" placeholder="此為日後登入帳號"
                                        required name="email" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputPassword"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>密碼</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="inputPassword"
                                        placeholder="6~15字元，至少搭配 1 個英文字母" required name="pwd">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputPasswordAgain"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>再次輸入密碼 </label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="password" class="form-control" id="inputPasswordAgain"
                                        placeholder="請再輸入一次密碼" required name="repwd">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="inputUsername"
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"><span
                                        class="text-danger">*</span>姓名</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="text" class="form-control" id="inputUsername" placeholder="請填真實姓名"
                                        required name="uname" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">性別</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male"
                                            value="1" checked>
                                        <label class="form-check-label" for="male">男</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female"
                                            value="2">
                                        <label class="form-check-label" for="female">女</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label
                                    class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center">生日</label>
                                <div class="col-sm-7 align-self-center">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="year" class="form-control">
                                                <option value="0" selected="" disabled="">年</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                                <option value="2019">2019</option>
                                                <option value="2018">2018</option>
                                                <option value="2017">2017</option>
                                                <option value="2016">2016</option>
                                                <option value="2015">2015</option>
                                                <option value="2014">2014</option>
                                                <option value="2013">2013</option>
                                                <option value="2012">2012</option>
                                                <option value="2011">2011</option>
                                                <option value="2010">2010</option>
                                                <option value="2009">2009</option>
                                                <option value="2008">2008</option>
                                                <option value="2007">2007</option>
                                                <option value="2006">2006</option>
                                                <option value="2005">2005</option>
                                                <option value="2004">2004</option>
                                                <option value="2003">2003</option>
                                                <option value="2002">2002</option>
                                                <option value="2001">2001</option>
                                                <option value="2000">2000</option>
                                                <option value="1999">1999</option>
                                                <option value="1998">1998</option>
                                                <option value="1997">1997</option>
                                                <option value="1996">1996</option>
                                                <option value="1995">1995</option>
                                                <option value="1994">1994</option>
                                                <option value="1993">1993</option>
                                                <option value="1992">1992</option>
                                                <option value="1991">1991</option>
                                                <option value="1990">1990</option>
                                                <option value="1989">1989</option>
                                                <option value="1988">1988</option>
                                                <option value="1987">1987</option>
                                                <option value="1986">1986</option>
                                                <option value="1985">1985</option>
                                                <option value="1984">1984</option>
                                                <option value="1983">1983</option>
                                                <option value="1982">1982</option>
                                                <option value="1981">1981</option>
                                                <option value="1980">1980</option>
                                                <option value="1979">1979</option>
                                                <option value="1978">1978</option>
                                                <option value="1977">1977</option>
                                                <option value="1976">1976</option>
                                                <option value="1975">1975</option>
                                                <option value="1974">1974</option>
                                                <option value="1973">1973</option>
                                                <option value="1972">1972</option>
                                                <option value="1971">1971</option>
                                                <option value="1970">1970</option>
                                                <option value="1969">1969</option>
                                                <option value="1968">1968</option>
                                                <option value="1967">1967</option>
                                                <option value="1966">1966</option>
                                                <option value="1965">1965</option>
                                                <option value="1964">1964</option>
                                                <option value="1963">1963</option>
                                                <option value="1962">1962</option>
                                                <option value="1961">1961</option>
                                                <option value="1960">1960</option>
                                                <option value="1959">1959</option>
                                                <option value="1958">1958</option>
                                                <option value="1957">1957</option>
                                                <option value="1956">1956</option>
                                                <option value="1955">1955</option>
                                                <option value="1954">1954</option>
                                                <option value="1953">1953</option>
                                                <option value="1952">1952</option>
                                                <option value="1951">1951</option>
                                                <option value="1950">1950</option>
                                                <option value="1949">1949</option>
                                                <option value="1948">1948</option>
                                                <option value="1947">1947</option>
                                                <option value="1946">1946</option>
                                                <option value="1945">1945</option>
                                                <option value="1944">1944</option>
                                                <option value="1943">1943</option>
                                                <option value="1942">1942</option>
                                                <option value="1941">1941</option>
                                                <option value="1940">1940</option>
                                                <option value="1939">1939</option>
                                                <option value="1938">1938</option>
                                                <option value="1937">1937</option>
                                                <option value="1936">1936</option>
                                                <option value="1935">1935</option>
                                                <option value="1934">1934</option>
                                                <option value="1933">1933</option>
                                                <option value="1932">1932</option>
                                                <option value="1931">1931</option>
                                                <option value="1930">1930</option>
                                                <option value="1929">1929</option>
                                                <option value="1928">1928</option>
                                                <option value="1927">1927</option>
                                                <option value="1926">1926</option>
                                                <option value="1925">1925</option>
                                                <option value="1924">1924</option>
                                                <option value="1923">1923</option>
                                                <option value="1922">1922</option>
                                                <option value="1921">1921</option>
                                                <option value="1920">1920</option>
                                                <option value="1919">1919</option>
                                                <option value="1918">1918</option>
                                                <option value="1917">1917</option>
                                                <option value="1916">1916</option>
                                                <option value="1915">1915</option>
                                                <option value="1914">1914</option>
                                                <option value="1913">1913</option>
                                                <option value="1912">1912</option>
                                                <option value="1911">1911</option>
                                                <option value="1910">1910</option>
                                                <option value="1909">1909</option>
                                                <option value="1908">1908</option>
                                                <option value="1907">1907</option>
                                                <option value="1906">1906</option>
                                                <option value="1905">1905</option>
                                                <option value="1904">1904</option>
                                                <option value="1903">1903</option>
                                                <option value="1902">1902</option>
                                                <option value="1901">1901</option>
                                                <option value="1900">1900</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="month" class="form-control">
                                                <option value="0" selected="" disabled="">月</option>
                                                <option value="1">1月</option>
                                                <option value="2">2月</option>
                                                <option value="3">3月</option>
                                                <option value="4">4月</option>
                                                <option value="5">5月</option>
                                                <option value="6">6月</option>
                                                <option value="7">7月</option>
                                                <option value="8">8月</option>
                                                <option value="9">9月</option>
                                                <option value="10">10月</option>
                                                <option value="11">11月</option>
                                                <option value="12">12月</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 py-2">
                                            <select name="day" class="form-control">
                                                <option value="0" selected="" disabled="">日</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                                <option value="21">21</option>
                                                <option value="22">22</option>
                                                <option value="23">23</option>
                                                <option value="24">24</option>
                                                <option value="25">25</option>
                                                <option value="26">26</option>
                                                <option value="27">27</option>
                                                <option value="28">28</option>
                                                <option value="29">29</option>
                                                <option value="30">30</option>
                                                <option value="31">31</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left align-self-center"
                                    for="inputPhone"><span class="text-danger">*</span>手機</label>
                                <div class="col-sm-7 align-self-center">
                                    <input type="phone" class="form-control" id="inputPhone" placeholder="請輸入電話"
                                        required name="tel" value="">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right text-sm-left"><span
                                        class="text-danger">*</span>地址</label>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-sm-12">
                                            <select id="city" class="form-control" name="city" data-width="fit">
                                                <option value="" selected="" disabled="">縣市</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12">
                                            <select id="city" class="form-control" name="district"
                                                data-width="fit">
                                                <option value="0">鄉鎮市區</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <input type="text" class="form-control" id="address" placeholder=""
                                                required name="addr" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label text-md-right pr-0 align-self-center"><span
                                        class="text-danger">*</span>輸入右方驗證碼</label>
                                <div class="col-sm-7  align-self-center">
                                    <div class="input-group">
                                        <input type="text" class="form-control align-self-center" id="verify"
                                            placeholder="" required name="captcha">
                                        <div class="d-flex pl-2 align-self-center">
                                            <img src="{{ route('captcha') }}" width="68px" height="24px"
                                                class="img-fluid captchaImg" />
                                        </div>
                                        <div class="input-group-append">
                                            <label class="refresh mn-0">
                                                <a class="btn btn-refresh hvr-icon-spin">更換 <i
                                                        class="fas fa-sync-alt hvr-icon px-1"></i>
                                                </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="" required>
                                            我已閱讀<a href="terms.php" class="text-danger px-1"
                                                target="_blank">會員條款</a>並同意接受條款內容
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <div class="col-sm-7 offset-sm-3 py-2">
                                    <input type="hidden" name="fb_id" value="">
                                    <button class="btn btn-lg btn-danger btn-purchase btn-block rounded-pill mb-3 hvr-grow"
                                        type="submit">確認送出</button>
                                    <button class="btn btn-lg bg-secondary text-white btn-block rounded-pill mb-3 hvr-grow"
                                        type="reset">取消重填</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        </div>
    </article>
@endpush
