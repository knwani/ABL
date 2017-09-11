<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref four-quarter-height">
          <div class="banner" style="background-image:url('/tenets/{{$data['tenet']->cover}}')">
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
                          <a href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
              <div class="middle_piece larger">
                <div class="tenet">{{$data['tenet']->category}}</div>
                <div class="seperator"></div>
                <div class="title">{{$data['tenet']->article_name}}</div>
                <div class="author">
                  <div class="image" style="background-image:url('/authors/{{$data['author']->avatar}}')"></div>
                  <span class="name">{{$data['author']->name}}</span>
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
              <div class="content flex">
                <div class="text flex">
                  {{$data['tenet']->content}}
                  <div class="spacer"></div>
                  <div class="footer">
                    <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
                    <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
                    <div class="icons"><i class="fa fa-instagram"></i><i class="fa fa-facebook-square"></i><i class="fa fa-twitter-square"></i></div>
                  </div>
                </div>
              </div>
              <div class="sidebar">
                <div class="text">
                <!--<span class="title"><i class="fa fa-align-left"></i>&nbsp;&nbsp;More from {{$data['tenet']->category}}</span>-->
                <span class="title"><i class="fa fa-align-left"></i>&nbsp;&nbsp;Recommended Reading</span>


                  @foreach ($data['recommended'] as $this_article)

                  <a href="{{ url('/tenets/' . $this_article->id . '/' . $this_article->tenetFriendly() . '/' . $this_article->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$this_article->cover}}')">
                    <div class="overlay"></div>
                    <div class="content">
                      {{$this_article->article_name}}
                    </div>
                  </a>

                  @endforeach
                </div>
              </div>
            </div>
        </div>



        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <script>
        $(document).ready(function(){
          //if the events are enough, create this fucking slider
          if($('.events').length > 4){
            $('.events').slick({
                 infinite: true,
                 slidesToShow: 3,
                 slidesToScroll: 3
              });
          }

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

          var s = $(".header");
          var pos = s.position();
          //alert(pos.top);

          $(window).scroll(function () {
              var windowpos = $(window).scrollTop();
              //s.html("Distance from top: " + pos.top + "<br/>Scroll position: " + windowpos);
              if (windowpos > pos.top) {
                  s.addClass("header_bg");
                  //s.addClass("stick");
              } else if (windowpos <= pos.top) {
                  //s.removeClass("stick");
                  s.removeClass("header_bg");
              }

          });
        });
        </script>

    </body>
</html>
