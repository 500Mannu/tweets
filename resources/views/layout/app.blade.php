<!DOCTYPE html>
<html>
  <head>
    <title>YDR Tweeter</title>
    <style>
      body {
        font-family: verdana, san-serif, arial;
      }
      .meta-date {
        font-size: 12px;
        color: #999;
      }
      .wrapper {
        width: 500px;
        margin: auto auto;
      }

      a {
        text-decoration: none;
      }

      .tweet-item {
        display: block;
        border-bottom: #eee thin solid;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div><h3>Twitter</h3></div>
      @yield('main')
    </div>
  </body>
</html>