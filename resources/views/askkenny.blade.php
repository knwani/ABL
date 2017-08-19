<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ask Kenny</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref five-quarter-height">
          <div class="banner skew">
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
                          <a href="{{ url('/about-us')}}">About Us</a>
                          <a href="{{ url('/feminique-woman')}}">Feminique Woman</a>
                          <a class="on" href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
              <div class="middle_piece larger">
                <div>
                  <p class="greeting">Hi there</p>
                  <p class="name">Mrs Kehinde Nwani</p>
                  <p class="first">I am a social entrepreneur, founder of the "A
                  Beautiful Life By Kenny Initiative", and founder, GMD/CEO Meadow Hall
                  Group.</a>
                </div>

                <div>

                </div>
              </div>

              <div class="two--show bio__portrait"></div>
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
              <p class="first">
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
referred to as a Life-long learner.
</p>
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
