var totalPages = 0
function pagination(offset) {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "pagination", "offset": offset },
        success: function (response) {
            // alert(response)
            var data = JSON.parse(response)
            var markup = `
            <div class="row">
            `
            data.forEach(i => {
                markup += `
                <div class="col-md-3 col-sm-6">
                    <div class="single-shop-product">
                        <div class="product-upper">
                            <img src="${i.product_images.split(",").length <= 1 ? "https://source.unsplash.com/200x200/?product" : "../" + i.product_images.split(",")[0]}" alt="" width="250" height="250">
                        </div>
                        <h2><a href="single-product.php?productId=${i.id}">${i.product_name}</a></h2>
                        <div class="product-carousel-price">
                            <ins><i class="fa fa-inr"></i> ${i.product_price}</ins> <del><i class="fa fa-inr"></i> 999.00</del>
                        </div>

                        <div class="product-option-shop">
                            <a class="add_to_cart_button" data-quantity="1" data-product_sku="" data-product_id="${i.id}" rel="nofollow" href="/canvas/shop/?add-to-cart=70">Add to cart</a>
                        </div>
                    </div>
                </div>
                `
                console.log(i)
            });
            markup += `
            </div>
            `
            $(".listProducts").html(markup)
        }
    });
}
function getTotalPages() {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "getTotalPages" },
        success: function (response) {
            if (!isNaN(parseInt(response))) {
                totalPages = parseInt(response)
                var markup = `
                <li class="page-item prev" style="display:none;"><a class="page-link" href="#">Previous</a></li>
                `
                for (let i = 0; i < parseInt(response); i++) {
                    markup += `
                    <li class="page-item ${i == 0 ? "active" : ""}" data="${i}"><a class="page-link" href="#">${i + 1}</a></li>
                    `
                }
                markup += `
                <li class="page-item next"><a class="page-link">Next</a></li>
                `
                $(".pagination").html(markup)
            }
        }
    });
}

getTotalPages()

var current = 1
// var total = parseInt($(".page-item").length) - 2
var total = 4
pagination(current - 1)
$("body").on("click", ".page-item", function () {
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

