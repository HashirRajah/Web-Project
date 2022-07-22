//after dom is loaded
$(document).ready(function(){
    //submit form
    $(document).on("click", "#submit", function() {
        let staff = {
            fname: $("#first-name").val(),
            lname: $("#last-name").val(),
            p_no: $("#phone-number").val(),
            email: $("#email").val(),
            username: $("#username").val(),
            passwd: $("#password").val()
        };
        addStaff(staff);
    });
});

//api url
const URL = "http://localhost/Web-Project/back-end/Admin/api/staff";
//ban comment
const addStaff = (staff) => {
    $.ajax({
        url: URL,
        data: {
            firstName: staff.fname,
            lastName: staff.lname,
            phoneNumber: staff.p_no,
            email: staff.email,
            username: staff.username,
            password: staff.passwd
        },
        accepts: "application/json",
        method: "POST",
        cache: false,
        error: function(xhr){
            alert("An error occured: " + xhr.status + " " + xhr.statusText);
        }
    }).done(function(data){
        data = JSON.parse(data);
        //
        let html;
        if(data.message === "Insert successful"){
            window.location.href = `staffs.php?message=${data.message}`;
        } else {
            html = data.message;
            $("#message").addClass("bg-danger fs-4 lead text-white").html(html);
        }
    });
};

