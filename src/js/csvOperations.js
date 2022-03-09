$(".export").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "../php/csv.php",
        data: { "action": "export" },
        success: function (response) {
            window.location.replace(response);
        }
    });
});

$(".import").click(function (e) {
    e.preventDefault();
    console.log("clicked")
    // $.ajax({
    //     type: "post",
    //     url: "../php/csv.php",
    //     data: { "action": "import" },
    //     success: function (response) {
    //         window.location.replace(response);
    //     }
    // });
});

$("#upload").change(function (e) {
    e.preventDefault();
    handleFileSelect(e)
});

function handleFileSelect(evt) {

    // evt.preventDefault()
    let files = evt.target.files;
    let f = files[0];
    let reader = new FileReader();
    reader.onload = (function (theFile) {
        return function (e) {
            // parseCsv(e.target.result)
            parseCsv(e.target.result)
            jQuery('#ms_word_filtered_html').val(e.target.result);
        };
    })(f);
    reader.readAsText(f);
}

function parseCsv(data) {
    $.ajax({
        type: "Post",
        url: "../php/csv.php",
        data: { "action": "csvToArray", "data": data },
        success: function (response) {
            var data = JSON.parse(response)
            console.log(data)
            var markup = `
                <table class="table table-striped table-sm csv">
                    <thead>
                    <tr>
                `
            data[0].forEach(i => {
                markup += `
                    <th>${i}</th>
                `
            });
            markup += `
                    </tr>
                    </thead>
                    <tbody>
            `
            data.shift()
            data.forEach(i => {
                markup += `<tr>`
                i.forEach(j => {
                    markup += `
                        <td>${j}</td>
                    `
                })
                markup += `<tr>`
            })
            markup += `
                    </thead>
                    </table>
            `
            $(".renderCsv").html(markup);
        }
    });
}

$("body").on("click", ".csv td", function () {
    $(this).attr("contenteditable", "true")
});

$("body").on("focusout", ".csv td", function () {
    $(this).attr("contenteditable", "false")
});

$(".read").click(function (e) {
    var tableToObject = []
    e.preventDefault();
    var tmp = []
    var l = $(".csv th").length
    for (let i = 0; i < l; i++) {
        console.log("row : " + $(`.csv th:eq(${i})`).text())
        tmp.push($(`.csv th:eq(${i})`).text())
    }
    tableToObject.push(tmp)
    for (let j = 0; j < $(".csv tr").length; j++) {
        tmp = []
        for (let i = 0; i < l; i++) {
            console.log("values : " + $(`.csv tr:eq(${j}) td:eq(${i})`).text())
            tmp.push($(`.csv tr:eq(${j}) td:eq(${i})`).text())
        }
        tableToObject.push(tmp)
    }
    var newTable = []
    for (let i = 0; i < tableToObject.length; i++) {
        if (i % 2 == 0) {
            newTable.push(tableToObject[i])
        }

    }
    console.log(newTable)
    $.ajax({
        type: "post",
        url: "../php/csv.php",
        data: { "action": "insert", "data": newTable },
        success: function (response) {
            $(".renderCsv").empty()
            $(".renderCsv").append(`<h1 class="p-3 text-success bg-light rounded-lg">Data Inserted Successfully</h1>`)
            $(".read").hide()
        }
    });

});