$("#FrmRegister_Member").submit(function (e) { 
    e.preventDefault();

    // Grab field values
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
        return;
    }
    if (lname === '') {
        alertify.error("Last Name is required.");
        return;
    }
    if (email === '') {
        alertify.error("Email is required.");
        return;
    }
    // Simple email pattern check
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alertify.error("Invalid email format.");
        return;
    }
    if (phone === '') {
        alertify.error("Phone number is required.");
        return;
    }
    // Phone number validation (basic, you can improve it)
    if (phone.length < 7) {
        alertify.error("Phone number is too short.");
        return;
    }
    if (!role) {
        alertify.error("Please select a role.");
        return;
    }
    if (!sex) {
        alertify.error("Please select sex.");
        return;
    }
    if (id_number === '') {
        alertify.error("ID Number is required.");
        return;
    }
    if (password === '') {
        alertify.error("Password is required.");
        return;
    }
    if (password.length < 6) {
        alertify.error("Password must be at least 6 characters.");
        return;
    }
    if (confirmPassword === '') {
        alertify.error("Confirm Password is required.");
        return;
    }
    if (password !== confirmPassword) {
        alertify.error("Passwords do not match.");
        return;
    }

    // If all validations pass, submit the AJAX request
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
                alertify.error(response.message);  // changed from alert() to alertify
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX error:", error);
            alertify.error("An unexpected error occurred.");
        }
    });
});
