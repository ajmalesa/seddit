// Required token for cross-site request forgery protection
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Run this when reply is clicked
$(document).on('click', '.reply', function() {
    // Prevent default action of link
    event.preventDefault();

    // Remove the hidden attribute of reply section to display the section to the user
    $("#" + this.id + ".reply_section").removeAttr("hidden");
});

// Run this when cancel button is clicked
$(document).on('click', '.cancel_reply', function() {
    // Prevent default action of link
    event.preventDefault();

    // Add the hidden attribute to a reply section to hide the section to the user
    $("#" + this.id + ".reply_section").attr("hidden", "");
});

// Run this when post reply is clicked
$(document).on('click', '.post_reply', function() {
    // Retrieve reply from reply box using JQuery ID + Class selector and store
    // in reply variable
    let reply = ($("#" + this.id + ".reply_box")[0]['value']);

    // Set the id to that will be sent in ajax post to the id from the comment 
    // that the reply button was clicked on
    let replied_to_id = this.id;

    // Grab meta variables from view to use in AJAX post method
    let user_id = $('meta[name=user_id]').attr('content');
    let post_id = $('meta[name=post_id]').attr('content');

    // Post comment using ajax post 
    $.ajax({
        type:'POST',
        url: '/comment/' + replied_to_id + '/reply',
        data: {
            replied_to_id:replied_to_id,
            comment:reply,
            user_id:user_id,
            post_id:post_id
        }
    });

    // Refresh the page to show updated comments
    location.reload();
});