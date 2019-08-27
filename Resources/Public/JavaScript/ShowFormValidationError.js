(function()
{
    let formValidationErrorResults = document.getElementsByClassName('formValidationErrorResult');

    if(formValidationErrorResults !== null && formValidationErrorResults.length !== 0)
    {
        for(let i = 0; i < formValidationErrorResults.length; ++i) {
            let validateError = formValidationErrorResults.item(i);

            let propertyName = validateError.childNodes.item(0).nodeValue;
            let realPropertyName = propertyName.slice(propertyName.indexOf('.') + 1);

            let formField = document.getElementById('addProductForm_' + realPropertyName);
            formField.style.backgroundColor = 'red';

            let formFieldErrMessage = document.getElementById('addProductFormErr_' + realPropertyName);
            formFieldErrMessage.innerHTML = '<em> Error Code ' + validateError.childNodes.item(1).childNodes.item(0).nodeValue + '</em>';
        }
    }
})();