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
                        <div class="tenets_front_man read"><i class="fa fa-align-left" ></i>&nbsp;&nbsp;Purposes</div>
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
                <div class="beautiful_life">
                  <div class="title">
                    About<br/>A Beautiful Life
                  </div>
                  <div class="content">
                    <p>
                        <strong>A Beautiful Life By Kenny </strong>
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
                        <br/><br/>
                        <strong>A Beautiful Life by Kenny</strong>
                        caters to the needs of women through her online platform as well as hosts
                        physical meetings.<br/><br/>
                    </p>
                    <p>
                        <strong>Vision</strong>
                    </p>
                    <p>
                        Based on the biblical Deborah, who was a prophetess, a wife, a maternal
                        figure, a judge, a warrior, a ruler, and a fearless patriot, the purpose of
                        the initiative is to raise women who are God chasers, wives, mothers,
                        workers/business owners, and nation builders after God’s heart.<br/><br/>
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
                    Mentoring sessions and much more,    <strong>A Beautiful Life By Kenny</strong> equips women to thrive
                        and excel in this Modern 21<sup>st</sup> century world.<br/><br/>
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
                <div class="other_bg">
                <div class="beautiful_life spacer nwani">
                  <div class="title">
                    About<br/>Mrs Nwani
                  </div>
                  <div class="content">
                    <p>
                    Mrs Kehinde Nwani is a social entrepreneur who is the founder of the “A
                    Beautiful Life By Kenny Initiative”. This Initiative was birthed from a
                    burden she had to mentor/guide women – aged 21+ - in order for them to
                    (through the leading of the Holy Spirit), truly live a Beautiful Life. She
                    is an Educationist who believes that education can be used as a viable tool
                    for societal development and through her role as the GMD/CEO Meadow Hall
                    Group, she is achieving this commendable feat. She has successfully grown
                    Meadow Hall Group, which started as a summer school in 2002 to an education
                    group with 6 sub-brands: Meadow Hall Education, Meadow Hall Consult, Meadow
                    Hall Foundation, Spring Meadow Edutainment, Meadow Hall Branchise and
                    Meadow Hall Resources. She obtained her Bachelor of Law degree from the
                    University of Ife (now Obafemi Awolowo University) 30 years ago and was
                    called to the Nigerian bar thereafter. She began her career as a Lawyer and
                    practiced law for about 14years before finally deciding to pursue her
                    lifelong passion - Education. She went further to study Education,
                    obtaining various diplomas, a Masters degree and is currently studying for
                    a PhD at the University of Leicester. She is someone who can truly be
                    referred to as a Life-long learner.<br/><br/>
                    </p>

                    <p>
                        She is happily married to Mr Andrew Nwani, the Founder and CEO of one of
                        the foremost IT and Digital solutions companies in Nigeria. The couple is
                        blessed with 3 wonderful Children.<br/><br/>
                    </p>

                    <p>
                      Mrs Kehinde Nwani is very passionate about National development and has
                      been widely recognized for her various pursuits, endeavours, achievements
                      and notable contribution to the growth of her country, Nigeria. Amongst
                      these awards are, ‘<strong>Entrepreneur of Our Time’</strong> by
                      Junior Achievement Nigeria in 2008.<strong>The Fellow for the Order of Sustainable Education</strong>’ by the Faculty of Education, Obafemi Awolowo University in 2012
                      ‘<strong>The Christian Business Woman of the Year</strong> by the Wise Women Awards in 2013, ‘, ‘<strong>Excellence in Quality Education’</strong> at the 2015 Nigeria
                      Entrepreneurs Awards. ‘<strong>National Outstanding Leadership Award 2016’</strong>, by the
                      National Association of Nigerian Students. She is a fellow of the    <strong>Institute of management consultants</strong>, and also a member of
                      different organizations such as <strong>WIMBIZ, LCCI</strong> etc.
                  </p>
                  </div>
                </div>
                <div>
              </div>
            </div>
            <div class="footer">
            <div>All Rights Reserved. A Beautiful Life © 2017</div>
            <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod™</a></div>
            <div class="icons"><i class="fa fa-instagram"></i><i class="fa fa-facebook-square"></i><i class="fa fa-twitter-square"></i></div>
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
