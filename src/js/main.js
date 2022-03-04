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


$("#updateProfile").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "../ajax.php",
        data: $('.updateProfileForm').serialize() + "&action=updateProfile",
        success: function (response) {
            if (response == "success") {
                $(".profileMsg").html("<div class='p-3 m-3 bg-light text-success'>Profile Succesfully updated</div>")
            }

        }
    });
});
$(".addCategory").click(function () {
    $(this).fadeOut(300)
    $('.addCategories').toggleClass('d-none')
});



$(".btnAddCategory").click(function (e) {
    var x = $(this).prev().val()
    if (x.trim() != '') {
        $('.addCategory').fadeIn(300)
        $('.addCategories').toggleClass('d-none')
        $.ajax({
            type: "post",
            url: "../ajax.php",
            data: { "action": "addCategory", "category": x },
            success: function (response) {
                if (response == "success") {
                    $(".categories").append(`<option value="${x}">${x}</option>`)
                    $(".notification").append(`<div class='p-3 rounded-lg text-success bg-light notification'>category added successfully</div>`)
                }
                else {
                    $(".notifcation").addClass("text-danger")
                    $(".notification").append(`<div class='p-3 rounded-lg text-success bg-light notification'>category is already present</div>`)

                }

            }
        });
    }
});

$(".productEdit").click(function (e) {
    e.preventDefault();
    alert("click")
});


function pagination(offset) {
    $.ajax({
        type: "post",
        url: "../ajax.php",
        data: { "action": "pagination", "offset": offset },
        success: function (response) {
            var data = JSON.parse(response)
            var markup = `
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Product quantity</th>
                        <th>Product uploader</th>
                        <th>Product Category</th>
                        <th>Product Desc</th>
                        <th>Product rating</th>
                        <th>Product images</th>
                    </tr>
                <tbody>
            `
            data.forEach(i => {
                markup += `
                <tr>
                <th>${i.id}</th>
                <th>${i.product_name}</th>
                <th>${i.product_price}</th>
                <th>${i.product_quantity}</th>
                <th>${i.product_category}</th>
                <th>${i.product_images}</th>
                <th>${i.product_desc}</th>
                <th>${i.product_rating}</th>
                <th>${i.product_uploader}</th>
                </tr>
                `
                console.log(i)
            });
            markup += `
            </tbody>
            </table>
            `
            $("#render").html(markup)
        }
    });
}
$(".page-item:eq(1)").addClass("active")
pagination(0)
var currentPage = 0
var totalPages = $(".page-item").length - 2
$(".page-item").click(function (e) {
    e.preventDefault();
    if (!isNaN(parseInt($(this).attr("data")))) {
        $(".page-item").removeClass("active")
        $(this).addClass("active")
        currentPage = parseInt($(this).attr("data"))
        pagination($(this).attr("data") * 5)
    }
    else {
        if (totalPages == currentPage + 2) {
            $(".next").hide()
        }
        // alert(currentPage)
        if ($(this).text() == "Next") {
            $(".page-item").removeClass("active")
            currentPage++
            pagination(currentPage * 5)
            $(`.page-item:eq(${currentPage + 1})`).addClass("active")
        }
        else {
            $(".page-item").removeClass("active")
            currentPage--
            pagination(currentPage * 5)
            $(`.page-item:eq(${currentPage - 1})`).addClass("active")
        }
    }
});