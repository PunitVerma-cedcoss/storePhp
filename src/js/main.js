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




var current = 1
var total = parseInt($(".page-item").length) - 2
pagination(current - 1)
$(`.page-item:eq(${current})`).addClass("active")
$(".prev").hide()
$(".page-item").click(function () {
    var n = $(this).text()
    if (!isNaN(parseInt(n))) {
        $(".next").show()
        $(".prev").show()
        $(".page-item").removeClass("active")
        $(this).addClass("active")
        current = parseInt($(this).text())
        if (current == total) {
            $(".next").hide()
        }
        if (current == 1) {
            $(".prev").hide()
        }
        pagination((current - 1) * 5)
    }
    else {
        if (n == "Next") {
            if (current < total - 1) {
                $(".prev").show()
                current++
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
                pagination((current - 1) * 5)
            }
            else {
                current++
                pagination((current - 1) * 5)
                $(".next").hide()
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
            }
        }
        else {
            if (current > 2) {
                $(".next").show()
                current--
                pagination((current - 1) * 5)
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
            }
            else {
                current--
                pagination((current - 1) * 5)
                $(".prev").hide()
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
            }
        }
    }
})