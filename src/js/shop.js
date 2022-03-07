var totalPages = 0
var current = 1
var sortBy = "id"
// var total = parseInt($(".page-item").length) - 2
var total = 4
$("#inlineFormSelectPref").change(function (e) {
    e.preventDefault();
    switch (parseInt($(this).val())) {
        case 1:
            sortBy = "product_price"
            totalPages = 0
            current = 1
            Sortpagination(current - 1, sortBy)
            getTotalPages()
            break
        case 2:
            sortBy = "product_id"
            totalPages = 0
            current = 1
            Sortpagination(current - 1, sortBy)
            getTotalPages()
            break
        case 3:
            sortBy = "product_rating"
            totalPages = 0
            current = 1
            Sortpagination(current - 1, sortBy)
            getTotalPages()
            break
        default:
            console.log("invalid choise")
            break
    }
});


function Sortpagination(offset, orderby = "id") {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "pagination", "offset": offset, "orderby": orderby },
        success: function (response) {
            console.log(response)
            var data = JSON.parse(response)
            var markup = ``
            data.forEach(i => {
                markup += `
                <div class="col">
                <div class="card shadow-sm">
                    <img src="${i.product_images.split(",").length <= 1 ? "https://source.unsplash.com/200x200/?product" : "../" + i.product_images.split(",")[0]}" alt="" class="img-fluid" style="height:300px;width:100%;">
                  <div class="card-body">
                    <h5>${i.product_name}</h5>
                    <p class="card-text">Sample text below</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <p><strong><i class="fa fa-inr"></i> ${i.product_price}</strong>&nbsp;<del><small class="link-danger">$180</small></del></p>
                      <button data-product_id="${i.id}" class="btn addToCart btn-primary">Add To Cart</button>
                    </div>
                  </div>
                </div>
              </div>
                `
                console.log(i)
            });
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
Sortpagination(current - 1, sortBy)
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
        Sortpagination((current - 1) * 5, sortBy)
    }
    else {
        if (n == "Next") {
            if (current < total) {
                $(".prev").show()
                // current++
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
                Sortpagination((current - 1) * 5, sortBy)
            }
            else {
                // current++
                Sortpagination((current - 1) * 5, sortBy)
                $(".next").hide()
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
            }
        }
        else {
            if (current > 1) {
                $(".next").show()
                // current--
                Sortpagination((current - 1) * 5, sortBy)
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
            }
            else {
                // current--
                Sortpagination((current - 1) * 5, sortBy)
                $(".prev").hide()
                $(".page-item").removeClass("active")
                $(`.page-item:eq(${current})`).addClass("active")
            }
        }
    }
})


$(".searchGo").click(function (e) {
    e.preventDefault()
    var x = $(".search").val().trim()
    if (x != "") {
        search(x)
    }
    else {
        sortBy = "id"
        totalPages = 0
        current = 1
        Sortpagination(current - 1, sortBy)
        getTotalPages()
    }

});

function search(text) {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "search", "query": text },
        success: function (response) {
            console.log(response)
            var data = JSON.parse(response)
            var markup = ``
            data.forEach(i => {
                markup += `
                <div class="col">
                <div class="card shadow-sm">
                    <img src="${i.product_images.split(",").length <= 1 ? "https://source.unsplash.com/200x200/?product" : "../" + i.product_images.split(",")[0]}" alt="" class="img-fluid" style="height:300px;width:100%;">
                  <div class="card-body">
                    <h5>${i.product_name}</h5>
                    <p class="card-text">Sample text below</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <p><strong><i class="fa fa-inr"></i> ${i.product_price}</strong>&nbsp;<del><small class="link-danger">$180</small></del></p>
                      <button data-product_id="${i.id}" class="addToCart btn btn-primary">Add To Cart</button>
                    </div>
                  </div>
                </div>
              </div>
                `
                console.log(i)
            });
            $(".listProducts").html(markup)
        }
    });
    totalPages = 0
    current = 1
    getTotalPages()
    $(".pagination").hide();
}


$("body").on("click", ".addToCart", function () {
    var x = $(this).text()
    if (x != "added")
        addToCart($(this).attr("data-product_id"), $(this))
});


function addToCart(id, ref) {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "addToCart", "id": id, },
        success: function (response) {
            if (response == "true") {
                showAdded(ref)
            }
        }
    });
}

function showAdded(ref) {
    ref.text("added")
    setTimeout(() => {
        ref.text("Add To Cart")
    }, 2000);

}