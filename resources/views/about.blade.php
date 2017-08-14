<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>About Us</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref four-quarter-height">
          <div class="banner">
            <div class="overlay"></div>
            <div class="content">
              <div class="header">
                <div class="shell">

                  <div class="shell_inner">

                    <div class="shell_logo">
                      <img src="{{ asset('/images/small_logo.png') }}"/>
                    </div>
                    <div class="morty">
                      <div class="tenets">
                        <div class="tenets_front_man read"><i class="fa fa-align-left" ></i>&nbsp;&nbsp;Tenets</div>
                        <ul class="menu">
                          <li><a href="{{ url('/tenets/gods-daughter')}}">God's Daughter</a></li>
                          <li><a href="{{ url('/tenets/wife')}}">Wife</a></li>
                          <li><a href="{{ url('/tenets/mother')}}">Mother</a></li>
                          <li><a href="{{ url('/tenets/career-woman')}}">Career Woman</a></li>
                          <li><a href="{{ url('/tenets/nation-builder')}}">Nation Builder</a></li>
                        </ul>
                      </div>
                      <div class="links">
                          <a href="/">Home</a>
                          <a class="on" href="{{ url('/about-us')}}">About Us</a>
                          <a href="{{ url('/feminique-woman')}}">Feminique Woman</a>
                          <a href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
              <div class="middle_piece larger">
                <div class="tenet">About Us</div>
              </div>

              <div class="grid">
                <div class="row">

                  <div class="item five"></div>
                  <div class="item ten"></div>
                  <div class="item seven"></div>
                  <div class="item twelve"></div>
                </div>
                <div class="row">
                  <div class="item one"></div>
                  <div class="item two"></div>
                  <div class="item three"></div>
                  <div class="item four"></div>
                </div>
                <div class="row">

                  <div class="item five"></div>
                  <div class="item six"></div>
                  <div class="item seven"></div>
                  <div class="item eight"></div>
                </div>

              </div>
            </div>
          </div>

            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="read_block">
              <div class="about">
<p>
    <strong><em>A Beautiful Life By Kenny </em></strong>
    is a non-profit initiative, based in Lagos Nigeria and launched by Kehinde
    Nwani in January 2016. This initiative was birthed from a desire to mentor
    and help women 21+ (and indeed all women in need of mentoring), reach their
    full potential as they lead their everyday lives. Remember the Bible
    admonishes in Titus 2: 3-5, “the older women likewise, that they be
    reverent in behavior, not slanderers, not given to much wine, be teachers
    of good things <strong><sup>4 </sup></strong>that they admonish the young
women to love their husbands, to love their children,    <strong><sup>5 </sup></strong><em>to be</em> discreet, chaste, homemakers,
    good, obedient to their own husbands, that the word of God may not be
    blasphemed.”
    <br/>
    <strong><em>A Beautiful Life by Kenny</em></strong>
    caters to the needs of women through her online platform as well as hosts
    physical meetings.
</p>
<p>
    <strong>Vision</strong>
</p>
<p>
    Based on the biblical Deborah, who was a prophetess, a wife, a maternal
    figure, a judge, a warrior, a ruler, and a fearless patriot, the purpose of
    the initiative is to raise women who are God chasers, wives, mothers,
    workers/business owners, and nation builders after God’s heart.
</p>
<p>
    <strong>Mission Statement </strong>
</p>
<p>
    Equipping every woman with tools needed to lead a beautiful and purposeful
    life. We believe that the purpose of life is to know and glorify God
    through an authentic relationship with Jesus Christ with the help of the
    Holy Spirit. This purpose is fulfilled first within ourselves, our families
    and then extended in love, to an increasingly broken world that desperately
    needs Him.
</p>
<p>
    Through our Website, Blog, Articles, Videos, Physical meetings, Retreats,
Mentoring sessions and much more,    <strong><em>A Beautiful Life By Kenny</em></strong> equips women to thrive
    and excel in this Modern 21<sup>st</sup> century world.
</p>
<p>
    <em></em>
</p>
<p>
    <strong>Declaration</strong>
</p>
<p>
    <em>I am a beautiful woman,</em>
</p>
<p>
    <em>Beautiful inside and out.</em>
</p>
<p>
    <em>I am a beautiful woman,</em>
</p>
<p>
    <em>Specially crafted to reflect God’s glory.</em>
</p>
<p>
    <em>I live a beautiful life, as I fulfill God’s purpose.</em>
</p>
<p>
    <em>I am beautiful;</em>
</p>
<p>
    <em>I am God’s child.</em>
</p>
              </div>
            </div>
        </div>



        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <script>
        $(document).ready(function(){
          //if the events are enough, create this fucking slider

          $(".tenets").click(function(){
            if($(".menu").css("display") == "none"){
              $(".menu").css("display", "block");
            } else {
              $(".menu").css("display", "none");
            }
            event.stopPropagation();
          });

          $("body").click(function(){
            $(".menu").css("display", "none");
          });
        });
        </script>

    </body>
</html>
