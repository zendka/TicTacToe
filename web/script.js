function autoSubmitIfComputerVsComputer() {
    if (computerVsComputer && !gameOver) {
        var forms = document.getElementsByTagName('form');
        var form = forms[0];
        setTimeout(function() {
            form.submit();
        }, 1000);
    }
}

function autoSubmitOnUserClick() {
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
    autoSubmitIfComputerVsComputer();
    autoSubmitOnUserClick()
};
