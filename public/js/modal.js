function modal_data(id) {
    var parent = document.getElementById("parent_id");
    parent.setAttribute("value", id);
}

function modal_edit(id) {
    var comment = document.getElementById("comment_id");
    comment.setAttribute("value", id);
    var messageid = ['message-']+id;
    var message = document.getElementById(messageid).textContent;
    document.getElementById('message').textContent=message;
}

function modal_close() {
    document.getElementById('message').textContent='';
}