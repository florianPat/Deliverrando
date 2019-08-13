var lastVisibleNavItem = '';

function showNavItem(id)
{
  if(lastVisibleNavItem !== '') {
    let element = document.getElementById(lastVisibleNavItem);
    if(element !== null) {
      element.style.visibility = 'collapse';
    }
  }

  lastVisibleNavItem = id + 'Child';
  let element = document.getElementById(lastVisibleNavItem);
  if(element !== null) {
    element.style.visibility = 'visible';
  }
}
