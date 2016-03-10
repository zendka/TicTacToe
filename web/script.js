window.onload = function() {
    emptyInputs = document.querySelectorAll('input[type=text]:not([readonly])');
    forms = document.getElementsByTagName('form');
    form = forms[0];

    autoSubmitIfComputerVsComputer();
    submitOnUserClick()
};

function autoSubmitIfComputerVsComputer() {
    if (isComputerVsComputer && !isGameOver) {
        setTimeout(function() {
            form.submit();
        }, 600);
    }
}

function submitOnUserClick() {
    for (var i=emptyInputs.length; i--;) {
        emptyInputs[i].onfocus = markAndSubmit;
    }
}

function markAndSubmit() {
    this.readOnly = true;
    this.value = currentPlayersMark;
    setTimeout(function() {
        form.submit();
    }, 250);
}
