    @if('local' === App::environment())
    <script type='text/javascript'>//<![CDATA[
    document.write("<script async src='//HOST:3000/browser-sync/browser-sync-client.1.5.8.js'><\/script>".replace(/HOST/g, location.hostname).replace(/PORT/g, location.port));
    //]]></script>
    @endif
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>