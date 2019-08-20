var lastVisibleNavItem = '';

function showNavItem(id)
{
  if(lastVisibleNavItem !== '') {
    let elements = document.getElementsByClassName(lastVisibleNavItem);
    if(elements !== null) {
      for (let i = 0; i < elements.length; ++i) {
        elements[i].style.display = 'none';
      }
    }
    else {
      console.log("items");
    }
  }

  lastVisibleNavItem = id + 'Child';
  let elements = document.getElementsByClassName(lastVisibleNavItem);
  if(elements !== null) {
    for(let i = 0; i < elements.length; ++i)
      elements[i].style.visibility = 'visible';
  }
}

(function ()
{
  let operationMsg = document.getElementById('operationMsg');
  if(operationMsg !== null) {
    setTimeout(() => operationMsg.style.visibility = 'collapse', 2000);
    //TODO: Can I do that nicer?
    setTimeout(() => document.getElementById('redirectLinkThing').click(), 2100);
  }
})();

(function()
{
  let formValidationErrorResults = document.getElementsByClassName('formValidationErrorResult');

  if(formValidationErrorResults.length !== 0)
  {
    let validateError = null;

    for(let i = 0; i < formValidationErrorResults.length; ++i) {
      validateError = formValidationErrorResults.item(i);
      console.log(validateError);

      let propertyName = validateError.childNodes.item(0).nodeValue;
      let realPropertyName = propertyName.slice(propertyName.indexOf('.') + 1);

      let formField = document.getElementById('addProductForm_' + realPropertyName);
      formField.style.backgroundColor = 'red';

      let formFieldErrMessage = document.getElementById('addProductFormErr_' + realPropertyName);
      formFieldErrMessage.innerHTML = '<em> Error Code ' + validateError.childNodes.item(1).childNodes.item(0).nodeValue + '</em>';
    }
  }
})();