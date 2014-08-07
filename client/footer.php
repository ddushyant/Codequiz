<script type="text/javascript">

$('#logout').click(function(e){
    $.ajax({
        type: "POST",
        url: "http://web.njit.edu/~jdl38/application_server/app.php/logout",
        dataType: "json",
        success: function(d) {
            window.location.replace("http://web.njit.edu/~arm32/client");
        },
        error: function(e) {
            window.location.replace("http://web.njit.edu/~arm32/client");
        },
    });
});
</script>
