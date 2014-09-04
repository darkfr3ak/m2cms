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
        </script>
    </body>
</html>