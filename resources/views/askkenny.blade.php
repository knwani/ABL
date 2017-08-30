<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ask Kenny</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref full-height">
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
              <div class="middle_piece larger no_padding">
                <div>
                  <p class="greeting">Hi there</p>
                  <p class="name">Mrs Kehinde Nwani</p>
                  <p class="first">I am a social entrepreneur, founder of the "A
                  Beautiful Life By Kenny Initiative", and founder, GMD/CEO Meadow Hall
                  Group.
                  <br/>
                  <br/>
                  Do ask me anything</p>
                </div>

                <div>

                </div>
              </div>

              <div class="two--show bio__portrait bio_bounce"></div>
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
              <div class="questions_bg">
                <div class="questions">
                  <div class="top_header">
                    <span class="title">Questions</span>
                    <a class="ask button" onclick="showModal()">Ask a question</a>
                  </div>

                  <div class="content">
                    @if($data['questions']->isEmpty())

                    <div class="empty">
                      No questions have been asked yet. You could be the first. Go ahead, ask a question
                    </div>

                    @else



                    @endif
                  </div>


                </div>
              </div>

              <div class="footer">
                <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
                <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
                <div class="icons"><i class="fa fa-instagram"></i><i class="fa fa-facebook-square"></i><i class="fa fa-twitter-square"></i></div>
              </div>
            </div>

          </div>
        </div>

        <div class="parentModal ng-scope" style="">

        <div class="close" onclick="closeModal()"><i class="fa fa-close fa-fw"></i></div>

        <div class="parentModal_child">

          <div class="section_header">Ask a question</div>

          <form method="post">
            <textarea id="rum" class="more_bottom_margin" placeholder="Keep your question straight to the point, on one topic and under 140 characters" maxlength="140"></textarea>
          </form>

          <div class="buttons social">
            <a class="button facebook" onclick="askQuestion('Facebook')"><i class="fa fa-facebook-official"></i>Ask with Facebook</a>
            <a href="" class="button twitter"><i class="fa fa-twitter-square"></i>Ask with Twitter</a>
            <a href="" class="button google"><i class="fa fa-google-plus-square"></i>Ask with Google</a>
          </div>
        </div>

        </div>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="{{ asset('/js/ninja.js') }}"></script>

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
