// Show hidden post when show is clicked and hide show post display message
$(document).on('click', '.show-post-class', function() {
    document.getElementById('hiddenPostID-' + this.id.split('-')[1]).classList.remove('d-none');
    document.getElementById('hiddenPostMessage-' + this.id.split('-')[1]).classList.add('d-none');
});

// Hide delete button if the user clicks it and show confirmation messsage
$(document).on('click', '.delete-button', function() {
    // Get the ID of the post that was selected
    let postID = this.getAttribute('postNumber');
    
    // Hide the delete button that was clicked
    this.style.display = "none";

    // Show yes and no confirmation options
    $('#confirm-delete-for-' + postID)[0].style.display = "inline";
})

// Hide the confirmation button if the user cancels the delete and show the delete button again
$(document).on('click', '.cancel-delete', function() {
    // Get the ID of the post that was selected
    let postID = this.getAttribute('postNumber');

    // Hide the confirm delete options
    this.parentElement.style.display = "none";

    // Show the delete button again
    $('#delete-button-for-' + postID)[0].style.display = "inline";
})
