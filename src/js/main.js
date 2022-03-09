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
                        <th>Edit/Delete</th>
                    </tr>
                <tbody>
            `
            data.forEach(i => {
                markup += `
                <tr>
                <td>${i.id}</td>
                <td>${i.product_name}</td>
                <td>${i.product_price}</td>
                <td>${i.product_quantity}</td>
                <td>${i.product_category}</td>
                <td>${i.product_images.split(",").join("\n")}</td>
                <td>${i.product_desc.length > 50 ? i.product_desc.substr(0, 50) + "..." : i.product_desc}</td>
                <td>${i.product_rating}</td>
                <td>${i.product_uploader}</td>
                <td><a href="editProduct.php?productId=${i.id}">Edit</a> <a href="#" class="deleteProduct" data="${i.id}">Delete</a></td>
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

$("body").on("click", ".deleteProduct", function () {
    deleteProduct($(this).attr("data"), $(this))
});

function deleteProduct(id, ref) {
    console.log(id)
    $.ajax({
        type: "post",
        url: "../ajax.php",
        data: { "action": "deleteProduct", "id": id },
        success: function (response) {
            if (response == "success") {
                $(".msg").html(`
                <div class="p-3 text-success rounded-lg bg-light">Product deleted successfully</div>
                `);
                ref.parent().parent().remove()
            }
            else {
                $(".msg").html(`
                <div class="p-3 text-danger rounded-lg bg-light">error deleting product</div>
                `);
            }
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


$(".searchBtn").click(function (e) {
    var query = $(".searchInput").val()
    e.preventDefault();
    if (query != "") {
        $.ajax({
            type: "post",
            url: "../ajax.php",
            data: { "action": "search", "query": query },
            success: function (response) {
                console.log(response)
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
                            <th>Edit/Delete</th>
                        </tr>
                    <tbody>
                `
                data.forEach(i => {
                    markup += `
                    <tr>
                    <td>${i.id}</td>
                    <td>${i.product_name}</td>
                    <td>${i.product_price}</td>
                    <td>${i.product_quantity}</td>
                    <td>${i.product_category}</td>
                    <td>${i.product_images.split(",").join("\n")}</td>
                    <td>${i.product_desc.length > 50 ? i.product_desc.substr(0, 50) + "..." : i.product_desc}</td>
                    <td>${i.product_rating}</td>
                    <td>${i.product_uploader}</td>
                    <td><a href="editProduct.php?productId=${i.id}">Edit</a> <a href="#" class="deleteProduct" data="${i.id}">Delete</a></td>
                    </tr>
                    `
                    console.log(i)
                });
                markup += `
                </tbody>
                </table>
                `
                $("#render").html(markup)
                $(".navigation").hide();
                $(".searchInput").val("")
            }
        });
    }
    else {
        $(".navigation").hide();
        current = 1
        total = parseInt($(".page-item").length) - 2
        pagination(current - 1)
    }
});