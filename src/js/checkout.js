var promoCode = ""
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
                var markup = ''
                data.forEach(i => {
                    totalCart += parseInt(i.product_price)
                    markup += `
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">${i.product_name} x${i.product_quantity}</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">$${i.product_price}</span>
                    </li>
                    `
                });
                $(".renderCart").html(markup)
                // $(".cartTotal").text("$" + totalCart + "-/")
            }
            else {
                $(".renderCart").html(`
                <h1>Go to shopping u Fool</h1>
                `)
            }
        }
    });
}

loadCart()

function applyPromo(x) {
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        data: { "action": "applyPromo", "promoCode": x },
        success: function (response) {
            alert(JSON.parse(response))
            if (response == "true") {
                promoCode = x
                $(".renderCart").append(`
                <li class="list-group-item d-flex justify-content-between bg-light">
                <div class="text-success">
                  <h6 class="my-0">Promo code</h6>
                  <small>${x}</small>
                </div>
                <span class="text-success">−$5</span>
              </li>
                `)
                $(".redeemCode").val("")
            }
            else {
                $(".msg").text(JSON.parse(response))
            }
        }
    });
}

$(".redeem").click(function (e) {
    e.preventDefault()
    var x = $(".redeemCode").val()
    if (x != "") {
        applyPromo(x)
    }
})

$("#checkout").click(function (e) {
    e.preventDefault();
    // console.log($(".checkoutForm").serializeArray())
    console.log()
    $.ajax({
        type: "post",
        url: "../../ajax.php",
        // data: $(".checkoutForm").serialize() + "&action=checkout" + promoCode.length > 0 ? "&promo=true" : "",
        data: $(".checkoutForm").serialize() + "&action=checkout&promoCode=" + promoCode,
        success: function (response) {
            console.log(response)
            if (response == "success") {
                $(".ordered").show()
                $(".checkoutForm").reset()
            }
        }
    });
});