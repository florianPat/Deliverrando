(function(){
    if(document.getElementById('vueOrderList') !== null) {
        const OrderList = {
            data() {
                return {
                    finishedOrderTracker: [],
                    orders: [],
                    ajaxLink: '',
                    udpateProgressLink: '',
                    xhttp: null,
                };
            },
            methods: {
                sendProgressUpdate(orderTrackerRecord, productIndex) {
                    let sendParams = new URLSearchParams();
                    sendParams.set('orderUid', orderTrackerRecord.uid);
                    sendParams.set('productIndex', productIndex);

                    let xhttp = new XMLHttpRequest();
                    xhttp.open('POST', this.updateProgressLink, true);
                    xhttp.send(sendParams);
                },
                checkboxChange(orderIndex, productIndex)
                {
                    console.assert(this.finishedOrderTracker[orderIndex] !== undefined, 'finishedOrderTracker-entry needs to be defined!');

                    let orderTrackerRecord = this.finishedOrderTracker[orderIndex];

                    orderTrackerRecord.checked[productIndex] = !orderTrackerRecord.checked[productIndex];

                    if(orderTrackerRecord.checked[productIndex]) {
                        --orderTrackerRecord.count;

                        this.sendProgressUpdate(orderTrackerRecord, productIndex);

                        if(orderTrackerRecord.count === 0) {
                            orderTrackerRecord.href = this.orders[orderIndex].finishLink;
                            orderTrackerRecord.color = 'cornflowerblue';
                        }
                    } else {
                        this.sendProgressUpdate(orderTrackerRecord, productIndex);
                        orderTrackerRecord.href = "#";
                        orderTrackerRecord.color = 'slategray';
                        ++orderTrackerRecord.count;
                    }
                },
                triggerAjax()
                {
                    this.xhttp.open('POST', this.ajaxLink, true);
                    this.xhttp.send();
                },
            },
            created()
            {
                // NOTE: I use this so that I do not have to compute the cHash myself (in some php code that I would have to call
                // before I start the ajax request.
                // NOTE: Moreover, I have to link to a different page, so that the other page can have another
                // typoscript template associated with it.
                const ajaxUrl = document.getElementById('ajaxUrl');
                this.ajaxLink = deescapeHtml(ajaxUrl.getAttribute('href'));

                const prgressUpdateUrl = document.getElementById('progressUpdateUrl');
                this.updateProgressLink = deescapeHtml(prgressUpdateUrl.getAttribute('href'));

                this.xhttp = new XMLHttpRequest();

                this.xhttp.onreadystatechange = () =>
                {
                    if(this.xhttp.readyState == 4 && this.xhttp.status == 200 && this.xhttp.responseURL.includes('page-1/ajaxbestellungen')) {
                        vue.$emit('ajaxResponse', JSON.parse(this.xhttp.responseText));
                    } else if(this.xhttp.readyState == 4 && this.xhttp.status >= 400) {
                        console.assert(!"InvalidCodePath", "InvalidCodePath");
                    }
                };

                setInterval(() => {
                   this.triggerAjax();
                }, 10000);

                this.triggerAjax();
            },
            mounted()
            {
                this.$root.$on('ajaxResponse', (jsonResponse) => {
                    this.orders = jsonResponse.orders;

                    this.finishedOrderTracker = [];
                    for(let order of this.orders) {
                        let productDescTracker = [];
                        for(let productDesc of order.productDescriptions) {
                            productDescTracker.push(false);
                        }
                        this.finishedOrderTracker.push({count: order.productDescriptions.length, href: "#",
                            color: 'slategray', uid: order.uid, checked: productDescTracker});
                    }
                });
            },
            template: `
                <div>
                    <div v-for="(order, index) in orders" class="card">
                        <h2 class="card-header">Order id: {{ order.uid }}</h2>
                        <div class="card-body">
                            <h4 class="card-subtitle">Person</h4>
                            <p class="card-text">Name: {{ order.person.name }}</p>
                            <p class="card-text">Address: {{ order.person.address }}</p>
                            <p class="card-text">Telephone number: {{ order.person.telephonenumber }}</p>
                            <br />
                            <div class="card-header">
                                Products
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item" v-for="(productDesc, pdIndex) in order.productDescriptions">
                                    x{{ productDesc.quantity }} {{ productDesc.productName }} 
                                    <input @change="checkboxChange(index, pdIndex);"
                                        type="checkbox" style="float: right">
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer text-muted">
                            <a class="card-link" :href="finishedOrderTracker[index].href" :style="{color: finishedOrderTracker[index].color}">Finished!</a>
                        </div>
                    </div>
                     
                    <div class="card" v-if="(orders.length % 2) !== 0"></div>
                </div>
            `
        };

        let vue = new Vue({
            el: '#vueOrderList',
            components: {
                'order-list': OrderList,
            },
        });
    }
})();