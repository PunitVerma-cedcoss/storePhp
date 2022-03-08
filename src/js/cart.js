function loadCart() {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "getCart" },
        success: function (response) {
            var data = JSON.parse(response)
            console.log(data)
            if (data.length > 0) {
                var totalCart = 0
                $(".total").text(data.length)
                var markup = `<tr>`
                data.forEach(i => {
                    totalCart += parseInt(i.product_price)
                    markup += `
                    <tr>
                    <td>${i.product_name}</td>
                    <td>${i.product_price}</td>
                    <td>
                      <input type="text" class="w-20" value="${i.product_quantity}">
                      <input type="button" class="btn btn-secondary ms-1 w-20 update" value="update" data="${i.id}">
                      <a href="#" class="link-danger deleteCart" data="${i.id}">Remove</a>
                    </td>
                    <td>$${parseInt(i.product_price) * parseInt(i.product_quantity)}</td>
                  </tr>
                    `
                });
                markup += `</tr>`
                $(".renderCart").html(markup)
                $(".cartTotal").text("$" + totalCart + "-/")
            }
            else {
                $(".renderCart").html(`
                <h1 class="text-center">Go to shopping u Fool</h1>
                `)
            }
        }
    });
}

loadCart()

function updateCartProduct(id, quantity) {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "updateCart", "productId": id, "quantity": quantity },
        success: function (response) {
            if (response == 1) {
                $(".notification").html(`
                <div class="text-success bg-light">
                    <p>Quantity was successfully updated</p>
                </div>
                `)
                loadCart()
            }
        }
    });
}

function deleteFromCart(id) {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "deleteCart", "productId": id },
        success: function (response) {
            if (response == 1) {
                $(".notification").html(`
                <div class="text-success bg-light">
                    <p>Product was successfully deleted</p>
                </div>
                `)
                loadCart()
            }
        }
    });
}

// onclick update
$("body").on("click", ".update", function (e) {
    e.preventDefault()
    var x = $(this).prev().val().trim()
    console.log($(this).attr("data"))
    if (x != '') {
        updateCartProduct($(this).attr("data"), x)
    }
});

// onclick delete
$("body").on("click", ".deleteCart", function (e) {
    e.preventDefault()
    var x = $(this).attr("data")

    if (x != '') {
        deleteFromCart(x)
    }
});


$(".checkout").click(function (e) {
    e.preventDefault();
    window.location.replace("checkout.php");
});