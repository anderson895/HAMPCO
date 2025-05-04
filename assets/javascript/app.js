$("#frmLogin_Admin").submit(function (e) { 
    e.preventDefault();
    $('.spinner').show();
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'Login_Admin' });
    var serializedData = $.param(formData);

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: serializedData,
        dataType: "json", 
        success: function (response) {
            if (response.status === 'success') {
                alertify.success(response.message);  
                setTimeout(function () {
                    window.location.href = "admin/admin_dashboard"; 
                }, 1000);
            } else {
                alertify.error(response.message); 
                $('.spinner').hide();
            }
        }
    });
});



$("#FrmLogin_Member").submit(function (e) { 
    e.preventDefault();
    $('.spinner').show();
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'LoginMember' });
    var serializedData = $.param(formData);

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: serializedData,
        dataType: "json", 
        success: function (response) {
            if (response.status === 'success') {
                alertify.success(response.message);  
                setTimeout(function () {
                    window.location.href = "member/member_dashboard"; 
                }, 1000);
            } else {
                alertify.error(response.message); 
                $('.spinner').hide();
            }
        }
    });
});



$("#FrmRegister_Member").submit(function (e) { 
    e.preventDefault();
    $('.spinner').show();

    var fname = $("#first-name").val().trim();
    var lname = $("#last-name").val().trim();
    var email = $("#email").val().trim();
    var phone = $("#phone").val().trim();
    var role = $("#role").val();
    var sex = $("#sex").val();
    var id_number = $("#id_number").val().trim();
    var password = $("#password").val();
    var confirmPassword = $("#confirm-password").val();

    // Basic validation
    if (fname === '') {
        alertify.error("First Name is required.");
        $('.spinner').hide(); // ❗ Hide spinner if validation fails
        return;
    }
    if (lname === '') {
        alertify.error("Last Name is required.");
        $('.spinner').hide();
        return;
    }
    if (email === '') {
        alertify.error("Email is required.");
        $('.spinner').hide();
        return;
    }
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alertify.error("Invalid email format.");
        $('.spinner').hide();
        return;
    }
    if (phone === '') {
        alertify.error("Phone number is required.");
        $('.spinner').hide();
        return;
    }
    if (phone.length < 7) {
        alertify.error("Phone number is too short.");
        $('.spinner').hide();
        return;
    }
    if (!role) {
        alertify.error("Please select a role.");
        $('.spinner').hide();
        return;
    }
    if (!sex) {
        alertify.error("Please select sex.");
        $('.spinner').hide();
        return;
    }
    if (id_number === '') {
        alertify.error("ID Number is required.");
        $('.spinner').hide();
        return;
    }
    if (password === '') {
        alertify.error("Password is required.");
        $('.spinner').hide();
        return;
    }
    if (password.length < 6) {
        alertify.error("Password must be at least 6 characters.");
        $('.spinner').hide();
        return;
    }
    if (confirmPassword === '') {
        alertify.error("Confirm Password is required.");
        $('.spinner').hide();
        return;
    }
    if (password !== confirmPassword) {
        alertify.error("Passwords do not match.");
        $('.spinner').hide();
        return;
    }

    // All validations passed
    var formData = $(this).serializeArray(); 
    formData.push({ name: 'requestType', value: 'RegisterMember' });
    var serializedData = $.param(formData);

    $.ajax({
        type: "POST",
        url: "backend/end-points/controller.php",
        data: serializedData,
        dataType: "json", 
        success: function (response) {
            if (response.status === 'success') {
                alertify.success(response.message);  
                setTimeout(function () {
                    window.location.href = "login_member"; 
                }, 1000);
            } else {
                alertify.error(response.message); 
                $('.spinner').hide();
            }
        }
    });
});
