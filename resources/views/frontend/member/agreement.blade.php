@extends('frontend.layouts.app')

@push('app-content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-md-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">홈</a></li>
                            <li class="breadcrumb-item active" aria-current="page">회원약관</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <article class="page-wrapper my-3">
        <div class="container">
            <div class="page-title">
                <h2 class="text-black text-center font-weight-bold mb-0 aos-init aos-animate" data-aos="zoom-in-up"
                    data-aos-delay="450">회원약관</h2>
                <h4 class="text-center text-gold mb-4 aos-init aos-animate" data-aos="zoom-in-up" data-aos-delay="600">
                    Membership Terms</h4>
                <hr class="page_line aos-init aos-animate" data-aos="flip-right" data-aos-delay="0"
                    data-aos-duration="3000">
            </div>

            <section class="my-5 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="450">
                <p>저희 웹사이트를 방문하고 이용해 주셔서 감사합니다! EzHive 이군길선(이하 "EzHive 이군길선")은 지적재산권자의 존중과 보호를 위한 취지를 관철하기 위해,<br>본 웹사이트 이용 시 다음 사항을 준수해 주시기 바랍니다.</p>
                <br>
                <h4>인지 및 수락 조항</h4>
                <p>본 웹사이트에서 제공하시는 개인정보의 프라이버시를 보호하기 위해, "EzHive 이군길선"이 수집·사용할 수 있는 개인정보의 관련 상황과 범위는 다음과 같습니다. 본 페이지의 관련 조항을 수락하거나 준수할 수 없다면, 웹사이트 이용을 중단해 주시기 바랍니다. 계속해서 웹사이트를 이용하시는 경우,
                    이러한 조항들을 수락하고 준수하는 것으로 간주됩니다.</p>
                <br>
                <h4>회원 계정, 비밀번호 및 보안</h4>
                <p>회원가입 시 상세하고 정확한 개인정보를 제공해야 하며, 이후 변경사항이 있을 경우 온라인으로 수시 업데이트해 주시기 바랍니다.<br>
                    회원은 회원 및 각종 정보를 정확히 기입하여 회원 권익을 보장해야 합니다. 회원 정보 기입 오류로 인한 분쟁이 발생할 경우, 회원은 "EzHive 이군길선" 쇼핑몰에 대해 어떠한 보상도 요구할 수 없습니다.</p>
                <br>

                <p>회원은 비밀번호를 안전하게 보관해야 하며, 비밀번호를 누설하거나 다른 사람에게 알려주거나 사용하게 해서는 안 됩니다. 동일한 회원 이메일 계정과 비밀번호로 "EzHive 이군길선"에 접속한 후 수행된 모든 행위는 해당 회원 본인과 비밀번호 보유자의 행위로 간주됩니다.<br>
                    회원가입 시 반드시 사실에 근거한 개인정보를 기입해야 하며, 허위 등록이 발견될 경우 "EzHive 이군길선"은 해당 회원의 자격을 일시정지하거나 종료할 수 있습니다. 중화민국 관련 법률을 위반할 경우 법에 따라 추궁됩니다. 회원이 제3자가 자신의 회원 이메일 계정이나 비밀번호를 사용하고 있다고 발견하거나 의심할 경우, 즉시 "EzHive 이군길선"에 알리고 필요한 방어 조치를 취해야 합니다.
                </p>
                <br>

                <p>본 웹사이트는 정확하고 시의적절한 정보와 콘텐츠를 제공하기 위해 노력하지만, 이러한 정보와 콘텐츠는 현재 상황에 국한되며, 그 정확성과 시의성에 대해 본 웹사이트는 직접적이거나 간접적인 보장을 제공하지 않습니다. 귀하는 본 웹사이트의 자료가 기술적으로 부정확하거나 도표상의 오류를 포함할 수 있음을 이해하고 동의하며,
                    "EzHive 이군길선"은 언제든지 본 웹사이트를 수정하고 정정할 권리를 보유합니다. "EzHive 이군길선"은 본 웹사이트에 포함된 자료나 정보의 중화민국 외 지역에서의 사용 적절성과 유효성을 보장하지 않으며, 중화민국 외 지역에서 본 웹페이지를 열람하는 모든 사용자는 해당 지역의 법률을 준수할 책임이 있습니다.</p>
                <br>

                <h4>기타 면책 조항</h4>
                <p>"EzHive 이군길선"은 본 웹사이트에서 실수, 오류, 누락, 중단, 결함, 전송 지연, 컴퓨터 바이러스, 회선 장애 등이 발생하지 않을 것임을 보장하지 않으며, 본 웹사이트가 바이러스나 기타 유해한 소프트웨어 또는 프로그램의 침해로 인해 귀하의 사용상 불편, 자료 손실, 오류, 변조 또는 기타 경제적 손실이나 불이익 등의 상황이 발생하지 않을 것임을 보장할 수 없습니다. 본 웹사이트 이용 시 필요한 보호 조치를 스스로 취하시기를 권장합니다. "EzHive 이군길선"은 귀하가 본 웹사이트에서 제공하는 서비스를 이용하거나 이용할 수 없음으로 인해 발생하는 모든 손해에 대해 배상 책임을 지지 않습니다.
                </p>
                <br>

                <h4>개인정보 수집</h4>
                <p>귀하는 본 웹사이트에서 "EzHive 이군길선" 회원으로 가입하거나 "EzHive 이군길선"이 주최하는 온라인 이벤트나 온라인 추첨 이벤트 등에 참여할 수 있으며, "EzHive 이군길선"은
                    귀하가 자발적으로 회원가입하거나 온라인 이벤트 참여 시 작성·업로드한 신청서를 통해 귀하의 개인정보를 획득합니다. 여기에는 성명, 생년월일, 성별, 주소, 전화번호, 이메일 주소 등의 항목과 귀하가 제공한 기타 개인정보가 포함됩니다.</p>
            </section>
        </div>
    </article>
@endpush
