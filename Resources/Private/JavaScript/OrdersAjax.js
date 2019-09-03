(function(){
    if(document.getElementById('orderDisplay') !== null) {
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200 && this.responseURL.includes('page-1/ajaxbestellungen')) {
                document.getElementById('orderDisplay').innerHTML = this.responseText;
            } else if(this.readyState == 4 && this.status >= 400) {
                document.getElementById('orderDisplay').innerHTML = '<h1>Error!</h1> <p>' + this.responseText + '</p>';
            }
        }

        setInterval(() => {
            // NOTE: I use this so that I do not have to compute the cHash myself (in some php code that I would have to call
            // before I start the ajax request.
            // NOTE: Moreover, I have to link to a different page, so that the other page can have another
            // typoscript template associated with it.
            const ajaxUrl = document.getElementById('ajaxUrl');
            const href = deescapeHtml(ajaxUrl.getAttribute('href'));
            console.log(href);

            xhttp.open('POST', href, true);
            xhttp.send();
        }, 10000);
    }
})();

const deescapeHtml = function (text)
{
    var map = {
        '%5B': '[',
        '%5D': ']',
        '%3F': '?',
    };

    return text.replace(/%5B|%5D|%3F/g, (m) => { return map[m]; });
};