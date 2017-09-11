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
                <div class="tenet">{{$data['category']->name}}</div>
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

            <div class="xavier">

              <div class="tenets_new_block">

                @foreach ($data['tenets'] as $indexKey => $tenet)

                  @if ($indexKey == 1)

                  <div class="big_block">

                  <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                    <div class="overlay"></div>
                    <div class="content">
                      <div class="category_parent">
                        <span class="category">{{$tenet->category}}</span>
                      </div>
                      <span class="title">{{$tenet->article_name}}</span>
                    </div>
                  </a>

                  @elseif ($indexKey == 2)

                  <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                    <div class="overlay"></div>
                    <div class="content">
                      <div class="category_parent">
                        <span class="category">{{$tenet->category}}</span>
                      </div>
                      <span class="title">{{$tenet->article_name}}</span>
                    </div>
                  </a>

                  </div>

                  @elseif ($indexKey == 3)

                  <div class="big_block">

                  <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                    <div class="overlay"></div>
                    <div class="content">
                      <div class="category_parent">
                        <span class="category">{{$tenet->category}}</span>
                      </div>
                      <span class="title">{{$tenet->article_name}}</span>
                    </div>
                  </a>

                  @elseif ($indexKey == 4)

                  <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="bg small" style="background-image:url('/tenets/{{$tenet->cover}}')">
                    <div class="overlay"></div>
                    <div class="content">
                      <div class="category_parent">
                        <span class="category">{{$tenet->category}}</span>
                      </div>
                      <span class="title">{{$tenet->article_name}}</span>
                    </div>
                  </a>

                  </div>

                  @else

                  <a href="{{ url('/tenets/' . $tenet->id . '/' . $tenet->tenetFriendly() . '/' . $tenet->urlFriendly())}}" class="big_block">

                  <div class="bg" style="background-image:url('/tenets/{{$tenet->cover}}')">
                    <div class="overlay"></div>
                    <div class="content">
                      <div class="category_parent">
                        <span class="category">{{$tenet->category}}</span>
                      </div>
                      <span class="title">{{$tenet->article_name}}</span>
                    </div>
                  </div>

                </a>

                  @endif

                @endforeach

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
