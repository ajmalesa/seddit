// Required token for cross-site request forgery protection
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Run this code when arrow is clicked
$(document).on('click', '.arrows', function() {

    // Initialize point that will be added to 0, which will be changed 
    // depending on which arrow was selected
    var point = 0;

    // If the arrow that was clicked has a class of upvote_arrows, set
    // point to a positive 1, otherwise set to negative 1 and change 
    // classes to update colors to match vote
    if ($(this).hasClass('upvote_arrows') && !$(this).hasClass('voted_up')) {
        point += 1;
        $(this).addClass('voted_up');
        // Run for comment arrows only
        if(this.parentElement.classList.contains('comment-box')) {
            if ($(this.parentElement)[0].children[3].classList.contains('comment_arrows')) {
                if($(this.parentElement)[0].children[4].classList.contains('voted_down')) {
                    $(this.parentElement)[0].children[4].classList.remove('voted_down');
                    point += 1;
                }
            } 
        }

        // Run for votes on the currently opened post only
        else if(this.classList.contains('current_post_arrows')) {
            if(this.parentElement.children[2].classList.contains('voted_down')) {
                this.parentElement.children[2].classList.remove('voted_down');
                point += 1;
            };
        } 
        // Run for votes on any posts made on posts page
        else if (this.classList.contains('all_posts_arrow')) {
            if(this.parentElement.children[3].classList.contains('voted_down')) {
                this.parentElement.children[3].classList.remove('voted_down')
                point += 1;
            }
        }
    } else if (!$(this).hasClass('upvote_arrows') && !$(this).hasClass('voted_down')) {
        point -= 1;
        $(this).addClass('voted_down');
        // Run this code for comment arrows only
        if(this.parentElement.classList.contains('comment-box')) {
            if ($(this.parentElement)[0].children[4].classList.contains('comment_arrows')) {
                if( $(this.parentElement)[0].children[3].classList.contains('voted_up')) {
                    $(this.parentElement)[0].children[3].classList.remove('voted_up');
                    point -= 1;
                }
            } 
        }
        // Run for votes on the currently opened post only
        else if (this.classList.contains('current_post_arrows')) {
            if(this.parentElement.children[1].classList.contains('voted_up')) {
                this.parentElement.children[1].classList.remove('voted_up');
                point -= 1;
            };
        } 
        // Run for votes on any posts made on posts page
        else if (this.classList.contains('all_posts_arrow')) {
            if(this.parentElement.children[2].classList.contains('voted_up')) {
                this.parentElement.children[2].classList.remove('voted_up')
                point -= 1;
            }
        }
    } else if ($(this).hasClass('upvote_arrows') && $(this).hasClass('voted_up')) { 
        // Remove upvote class if upvote button is clicked again
        // and remove class to change color back to default
        point -= 1;
        $(this).removeClass('voted_up');
    } else if (!$(this).hasClass('upvote_arrows') && $(this).hasClass('voted_down')) { 
        // Remove downvote class when button if downvote button is clicked again
        // and remove class to change color back to default
        point += 1;
        $(this).removeClass('voted_down');
    } 

    // Set the id to that will be sent in ajax post to the id from the 
    // post that the arrows was clicked on
    var id = this.id;

    // Store what type of vote was made on comment to pass to backend
    let voteType = 'none';
    if(this.classList.contains('voted_up')) {
        voteType = "upvote";
    } else if(this.classList.contains('voted_down')) {
        voteType = "downvote";
    }


    // Send AJAX post to index page '/' with the id of element to update
    // and point amount to increment or decrement by
    if($(this).hasClass('comment_arrows')) {
        // Update point count for comment at front-end
        $("#" + id + ".comment_vote_count")[0].innerHTML = parseInt($("#" + id + ".comment_vote_count")[0].innerHTML) + point;

        // Send POST request to update comment vote count in back end (database)
        $.ajax({
            type:'POST',
            url:'/comment/' + id,
            data:{
                id:id, 
                point:point,
                voteType
            }      
        });
    } else {
        // Update point count for post at front-end
        $("#" + id)[0].innerHTML = parseInt($("#" + id)[0].innerHTML) + point;

        // Send POST request to update post vote count in back end (database)
        $.ajax({
            type:'POST',
            url:'/',
            data:{
                id:id, 
                point:point,
                voteType
            }      
        });
    }
});