const login = () => {
        const payload = {
                "user": $("#user").val(),
                "pass": $("#pass").val()
        }

        $.ajax({
                data: payload,
                url: './php/_login.php',
                type: 'post',
                beforeSend: function () {
                        $("#loading").html("Please wait...");
                },
                success: (response) => {
                        $("#loading").html("");
                        $("#error").hide();
                        location.href = response;
                },
                error: (err) => {
                        $("#loading").html("");
                        $("#error").show();
                }
        });

}
