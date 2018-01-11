<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>A Beautiful Life By Kenny</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/big.css') }}"  />
    </head>
    <body>
        <div class="flex-center position-ref four-quarter-height">
          <div class="banner no-height black">
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
                    <div class="morty">
                      <div class="tenets">
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
                          <a class="on" href="{{ url('/blog')}}">Blog</a>
                      </div>
                    </div>
                  </div>

                </div>


              </div>
            </div>
          </div>

            <div class="blog_block">

                <div class="blog_item read" >

                    <div class="author">
                      <div class="image" style="background-image:url('/authors/{{$data['blog']->authorData()['avatar']}}')"></div>
                      <span class="name">{{$data['blog']->authorData()['name']}}</span>
                    </div>
                    <div class="content">

                      <div class="title">{{$data['blog']->title}}</div>
                      <span class="date">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['blog']->created_at)->format('d M Y')}}</span>
                      <div class="body">
                        {!!html_entity_decode($data['blog']->getBody())!!}
                      </div>

                      <div id="disqus_thread"></div>
                      <script>

                      /**
                      *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                      *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                      /*
                      var disqus_config = function () {
                      this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                      this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                      };
                      */
                      (function() { // DON'T EDIT BELOW THIS LINE
                      var d = document, s = d.createElement('script');
                      s.src = 'https://abeautifullifebykenny.disqus.com/embed.js';
                      s.setAttribute('data-timestamp', +new Date());
                      (d.head || d.body).appendChild(s);
                      })();
                      </script>
                      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>



                    </div>


                </div>



            </div>

            <div class="recommended">

              <div class="recommended_read">
                <span class="sug">Read Next</span>
                @foreach ($data['recommended'] as $indexKey => $blog)
                  <a href="{{ url('/blog/' . $blog->id . '/' . $blog->titleFriendly())}}" class="blog_item" >

                      <div class="author">
                        <div class="image" style="background-image:url('/authors/{{$blog->authorData()['avatar']}}')"></div>
                        <span class="name">{{$blog->authorData()['name']}}</span>
                      </div>
                      <div class="content">

                        <div class="title">{{$blog->title}}</div>
                        <div class="body">{{$blog->getBodyPreview()}}</div>
                        <span class="date">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)->format('d M Y')}}</span>
                      </div>
                  </a>
                @endforeach

              </div>

            </div>

            <div class="footerholder">
              <div class="footer blog">
                <div>All Rights Reserved. A Beautiful Life &copy; 2017</div>
                <div>Designed with <i class="fa fa-heart"></i> in Lagos, Nigeria by <a href="http://ephodng.com" target="_blank">Ephod&trade;</a></div>
                <div class="icons"><a href="https://www.instagram.com/abeautifullifebykenny" target="_blank"><i class="fa fa-instagram"></i></a><a href="https://www.facebook.com/ablbykenny" target="_blank"><i class="fa fa-facebook-square"></i></a><a href="https://twitter.com/ablbykenny" target="_blank"><i class="fa fa-twitter-square"></i></a><a href="https://www.youtube.com/channel/UCgYF0G6EPQAfVIvaRa-oB2A" target="_blank"><i class="fa fa-youtube-square"></i></a></div>
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

    <script id="dsq-count-scr" src="//abeautifullifebykenny.disqus.com/count.js" async></script>
    </body>
</html>
