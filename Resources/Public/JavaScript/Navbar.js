var lastVisibleNavItem = '';

function showNavItem(id)
{
  if(lastVisibleNavItem !== '') {
    let elements = document.getElementsByClassName(lastVisibleNavItem);
    if(elements !== null) {
      for (let i = 0; i < elements.length; ++i) {
        elements[i].style.visibility = 'collapse';
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

(function () {
  let operationMsg = document.getElementById('operationMsg');
  if(operationMsg !== null) {
    setTimeout(() => operationMsg.style.visibility = 'collapse', 2000);
    //TODO: Can I do that nicer?
    setTimeout(() => document.getElementById('redirectLinkThing').click(), 2100);
  }
}())