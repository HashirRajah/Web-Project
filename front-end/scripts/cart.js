//after dom is loaded
$(document).ready(function(){
    //
    $(".add").click(function() {
        let id = $(this).attr("id");
        addItem(id);
    });
    //
    $(document).on("click", ".remove", function() {
        let id = $(this).attr("id");
        removeItem(id);
    });
    //
    $(document).on("click", ".increment", function() {
        let id = $(this).attr("id");
        incItem(id);
    });
    //
    $(document).on("click", ".decrement", function() {
        let id = $(this).attr("id");
        decItem(id);
    });
});

//api url
const URL = "http://localhost/Web-Project/front-end/processOrder.php";
//ban comment
function addItem(id) {
    $.ajax({
        url: URL,
        data: {
            id: id
        },
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let numItems = $("#cart-items-count").text();
        numItems = parseInt(numItems) + 1;
        $("#cart-items-count").text(numItems);
        //
        let html = ``;
        //
        $.each(data.items, function(i, item){
            html += `
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <img src="${item.img_link}" class="img-fluid rounded-pill" alt="${item.name} image" style="width:50px;height:50px">
                    </div>
                    <div class="col-sm-3 text-start">
                        ${item.name}
                    </div>
                    <div class="col-sm-2 text-start fw-bold">
                        ${item.unit_price}
                    </div>
                    <div class="col-sm-3 text-end fw-bold">
                        <button class="btn btn-sm btn-danger text-uppercase p-1 remove" id="remove_${item.id}">remove</button>
                    </div>
                </div>
                <div class="row m-4">
                    <div class="col-sm-5 text-end">
                        <button class="btn btn-sm btn-outline-danger text-uppercase p-1 fw-bolder decrement" id="decrement_${item.id}">-</button>
                    </div>
                    <div class="col-sm-2 text-center">${item.qty}</div>
                    <div class="col-sm-5 text-start">
                        <button class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder increment" id="increment_${item.id}">+</button>
                    </div>
                </div>
            </div>
            `;
        });
        //
        $(".all-items").html(html);
        $("#total-items").text(data.total_items);
        $("#total-price").text(data.total_price);
    });
};
//
function removeItem(id) {
    $.ajax({
        url: URL,
        data: {
            id: id
        },
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html = ``;
        //
        $.each(data.items, function(i, item){
            html += `
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <img src="${item.img_link}" class="img-fluid rounded-pill" alt="${item.name} image" style="width:50px;height:50px">
                    </div>
                    <div class="col-sm-3 text-start">
                        ${item.name}
                    </div>
                    <div class="col-sm-2 text-start fw-bold">
                        ${item.unit_price}
                    </div>
                    <div class="col-sm-3 text-end fw-bold">
                        <button class="btn btn-sm btn-danger text-uppercase p-1 remove" id="remove_${item.id}">remove</button>
                    </div>
                </div>
                <div class="row m-4">
                    <div class="col-sm-5 text-end">
                        <button class="btn btn-sm btn-outline-danger text-uppercase p-1 fw-bolder decrement" id="decrement_${item.id}">-</button>
                    </div>
                    <div id="qty-${item.id}" class="col-sm-2 text-center">${item.qty}</div>
                    <div class="col-sm-5 text-start">
                        <button class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder increment" id="increment_${item.id}">+</button>
                    </div>
                </div>
            </div>
            `;
        });
        //
        $(".all-items").html(html);
        $("#total-items").text(data.total_items);
        $("#total-price").text(data.total_price);
        $("#cart-items-count").text(data.total_items);
        
    });
};
//
function incItem(id) {
    $.ajax({
        url: URL,
        data: {
            id: id
        },
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html = ``;
        //
        $.each(data.items, function(i, item){
            html += `
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <img src="${item.img_link}" class="img-fluid rounded-pill" alt="${item.name} image" style="width:50px;height:50px">
                    </div>
                    <div class="col-sm-3 text-start">
                        ${item.name}
                    </div>
                    <div class="col-sm-2 text-start fw-bold">
                        ${item.unit_price}
                    </div>
                    <div class="col-sm-3 text-end fw-bold">
                        <button class="btn btn-sm btn-danger text-uppercase p-1 remove" id="remove_${item.id}">remove</button>
                    </div>
                </div>
                <div class="row m-4">
                    <div class="col-sm-5 text-end">
                        <button class="btn btn-sm btn-outline-danger text-uppercase p-1 fw-bolder decrement" id="decrement_${item.id}">-</button>
                    </div>
                    <div id="qty-${item.id}" class="col-sm-2 text-center">${item.qty}</div>
                    <div class="col-sm-5 text-start">
                        <button class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder increment" id="increment_${item.id}">+</button>
                    </div>
                </div>
            </div>
            `;
        });
        //
        $(".all-items").html(html);
        $("#total-items").text(data.total_items);
        $("#total-price").text(data.total_price);
        $("#cart-items-count").text(data.total_items);
    });
};
//
function decItem(id) {
    $.ajax({
        url: URL,
        data: {
            id: id
        },
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html = ``;
        //
        $.each(data.items, function(i, item){
            html += `
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <img src="${item.img_link}" class="img-fluid rounded-pill" alt="${item.name} image" style="width:50px;height:50px">
                    </div>
                    <div class="col-sm-3 text-start">
                        ${item.name}
                    </div>
                    <div class="col-sm-2 text-start fw-bold">
                        ${item.unit_price}
                    </div>
                    <div class="col-sm-3 text-end fw-bold">
                        <button class="btn btn-sm btn-danger text-uppercase p-1 remove" id="remove_${item.id}">remove</button>
                    </div>
                </div>
                <div class="row m-4">
                    <div class="col-sm-5 text-end">
                        <button class="btn btn-sm btn-outline-danger text-uppercase p-1 fw-bolder decrement" id="decrement_${item.id}">-</button>
                    </div>
                    <div id="qty-${item.id}" class="col-sm-2 text-center">${item.qty}</div>
                    <div class="col-sm-5 text-start">
                        <button class="btn btn-sm btn-outline-success text-uppercase p-1 fw-bolder increment" id="increment_${item.id}">+</button>
                    </div>
                </div>
            </div>
            `;
        });
        //
        $(".all-items").html(html);
        $("#total-items").text(data.total_items);
        $("#total-price").text(data.total_price);
        $("#cart-items-count").text(data.total_items);
    });
};
