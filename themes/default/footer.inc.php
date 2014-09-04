</div>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="themes/<?php echo THEME ?>/js/bootstrap.min.js"></script>
        <script>
        $(document).ready(function() {
            $('#olvidado').click(function(e) {
              e.preventDefault();
              $('div#form-olvidado').toggle('500');
            });
        });
        $(document).ready(function() {
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
        });
        </script>
    </body>
</html>