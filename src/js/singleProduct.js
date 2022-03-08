$("body").on("click", ".addToCart", function () {
    var x = $(this).text()
    alert("clicked")
    showAdded($(this))
    if (x != "added")
        addToCart($("#productName").text(), $(this).attr("data-product_id"), $(this), $("#inputQuantity").val())
});

function addToCart(name, id, ref, quantity) {
    console.log(name, id, ref, quantity)
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "addToCart", "id": id, "quantity": quantity },
        success: function (response) {
            if (response == "true") {
                showAdded(ref)
                loadCart()
                $(".empty").remove()
                $(".showCart").append(`<p>${name}</p>`)
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

function loadCart() {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "getCart" },
        success: function (response) {
            var data = JSON.parse(response)
            if (data.length) {
                var markup = ``
                data.forEach(i => {
                    markup += `
                <p class="m-0 p-0 text-white">${i.product_name} x${i.product_quantity}</p>
                `
                });
                $(".showCart").html(markup)
            }
            else {
                $(".showCart").html(`<p class="m-0 p-0 text-white">nothing here</p>`)
            }
        }
    });
}

loadCart()