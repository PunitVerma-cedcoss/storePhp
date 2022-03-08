$(".export").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "../php/csv.php",
        data: { "action": "export" },
        success: function (response) {
            window.location.replace(response);
        }
    });
});