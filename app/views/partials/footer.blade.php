    </div>
    @if('local' === App::environment())
      <script type='text/javascript' id="__bs_script__">//<![CDATA[
          document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.2.8.2.js'><\/script>".replace("HOST", location.hostname));
      //]]></script>
    @endif
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="/js/app.js"></script>
  </body>
</html>