$(".changeStatus").change(function (e) {
    e.preventDefault();
    var value = $(this).val()
    var id = $(this).attr("data")
    console.log($(this).attr("data"))
    changeStatus(value,id)
});


function changeStatus(value, id) {
    console.log(value + id)
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "changeStatus", "id": id, "status": value },
        success: function (response) {
            alert(response)
        }
    });
}