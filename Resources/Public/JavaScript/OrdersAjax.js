(function(){
    if(document.getElementById('orderDisplay') !== null) {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200 && this.responseURL.includes('page-1/ajaxbestellungen')) {
                document.getElementById('orderDisplay').innerHTML = this.responseText;
            } else if(this.readyState == 4 && this.status <= 400) {
                document.getElementById('orderDispaly').innerHTML = '<h1>Error!</h1>';
            }
        }

        setInterval(() => {
            // NOTE: I use this so that I do not have to compute the cHash myself (in some php code that I would have to call
            // before I start the ajax request.
            // NOTE: Moreover, I have to link to a different page, so that the other page can have another
            // typoscript template associated with it.
            let ajaxUrl = document.getElementById('ajaxUrl');
            let href = ajaxUrl.getAttribute('href');

            xhttp.open('POST', href, true);
            xhttp.send();
        }, 10000);
    }
})();