$(".status").click(function (e) {
    e.preventDefault();
    var x = $(this).parent().prev().prev().prev().html()
    if ($(this).text() == "approve") {
        $(this).removeClass("btn-success")
        $(this).addClass("btn-danger")
        $(this).text("disapprove")
    }
    else {
        $(this).removeClass("btn-danger")
        $(this).addClass("btn-success")
        $(this).text("approve")
    }
    if (x != '')
        toggleStatus(x)
});

$(".delete").click(function (e) {
    e.preventDefault();
    deleteUser($(this), $(this).parent().prev().prev().prev().prev().text())
});

function toggleStatus(x) {
    $.ajax({
        type: "post",
        url: "../ajax.php",
        data: { action: "toggleStatus", email: x },
        success: function (response) {
            console.log(response)
        }
    });
}
function deleteUser(self, x) {
    $.ajax({
        type: "post",
        url: "../ajax.php",
        data: { action: "deleteUser", email: x },
        success: function (response) {
            if (response == "success") {
                self.parent().parent().remove()
            }

        }
    });
}