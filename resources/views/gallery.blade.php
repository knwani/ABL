<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gallery</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/big.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref four-quarter-height">
          <div class="banner no-height">
            <div class="overlay"></div>
            <div class="content">
              <div class="header">
                <div class="shell">

                  <div class="shell_inner">
                    <div class="extreme">
                      <div class="mobile_menu">
                        <i class="fa fa-2x fa-bars"></i>
                      </div>
                      <div class="shell_logo">
                        <img src="{{ asset('/images/small_logo.png') }}"/>
                      </div>
                    </div>
                    <div class="morty black">
                      <div class="tenets black">
                        <div class="tenets_front_man black"><i class="fa fa-align-left" ></i>&nbsp;&nbsp;Purposes</div>
                        <ul class="menu">
                          <li><a href="{{ url('/tenets/gods-daughter')}}">God's Daughter</a></li>
                          <li><a href="{{ url('/tenets/wife')}}">Wife</a></li>
                          <li><a href="{{ url('/tenets/mother')}}">Mother</a></li>
                          <li><a href="{{ url('/tenets/career-woman')}}">Career Woman</a></li>
                          <li><a href="{{ url('/tenets/nation-builder')}}">Nation Builder</a></li>
                        </ul>
                      </div>
                      <div class="links black">
                          <a href="/">Home</a>
                          <a href="{{ url('/about-us')}}">About Us</a>
                          <a href="{{ url('/feminique-woman')}}">Feminique Woman</a>
                          <a href="{{ url('/unique-man')}}">Unique Man</a>
                          <a href="{{ url('/ask-kenny')}}">Ask Kenny</a>
                          <a class="on" href="{{ url('/gallery')}}">Gallery</a>
                          <a href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>



                  </div>



                </div>


              </div>
            </div>
          </div>

            <div class="read_block">
              <div class="fashion-read">

                <section class="content">

                  <div class="gallery">

                    @foreach ($data['files'] as $indexKey => $file)

                      <!--<div class="preview holder" style="background-image:url('/{{$file->getFirstImage()}}')"></div>-->

                      <a class="preview_holder" href="{{ url('/gallery/' . $file->getFolder() . '/')}}">
                        <div class="preview" style="background-image:url('/{{$file->getFirstImage()}}')"></div>
                        <div class="preview_title">{{$file->Name}}</div>
                      </a>

                      <!--{{$file->getFolder()}}
                      {{$file->getFirstImage()}}-->
                    @endforeach
                  </div>

                </section>

                <div class="footerholder">
                  <div class="footer x-footer-fashion">
                    <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
                    <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
                    <div class="icons"><a href="https://www.instagram.com/abeautifullifebykenny" target="_blank"><i class="fa fa-instagram"></i></a><a href="https://www.facebook.com/ablbykenny" target="_blank"><i class="fa fa-facebook-square"></i></a><a href="https://twitter.com/ablbykenny" target="_blank"><i class="fa fa-twitter-square"></i></a><a href="https://www.youtube.com/channel/UCgYF0G6EPQAfVIvaRa-oB2A" target="_blank"><i class="fa fa-youtube-square"></i></a></div>
                  </div>
                </div>
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
