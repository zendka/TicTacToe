function submitOnUserClick() {
    var inputs = document.getElementsByTagName('input');
    for (var i=inputs.length; i--;) {
        if (inputs[i].getAttribute('type') == 'text' && !inputs[i].readOnly) {
            inputs[i].onfocus = function() {
                this.readOnly = true;
                this.value = currentPlayer;
                var form = this.parentElement;
                setTimeout(function() {
                    form.submit();
                }, 500);
            }
        }
    }
}

window.onload = function() {
    submitOnUserClick()
};
