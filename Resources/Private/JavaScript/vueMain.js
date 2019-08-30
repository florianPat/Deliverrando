//TODO: Check why this does not work! (#modules I guess?)
//import OrderList from './Components/OrderList';

const Order = function(name)
{
    this.name = name;
    this.quantity = 1;
}

const OrderList = {
    data: function()
    {
        return {
            orders: Array,
            ordersAcc: Object,
        };
    },
    methods: {
        changeQuantity: function(order, value)
        {
            order.quantity += value;
            if(order.quantity <= 0)
            {
                const deleteIndex = this.ordersAcc[order.name];
                delete this.ordersAcc[order.name];
                if(deleteIndex == 0) {
                    this.orders.shift();
                } else if(deleteIndex == this.orders.length - 1) {
                    this.orders.pop();
                } else {
                    let newOrders = this.orders.slice(0, deleteIndex);
                    newOrders.push(this.orders.slice(deleteIndex + 1, this.orders.length));
                    this.orders = newOrders;
                }

                const ordersAccEntries = Object.entries(this.ordersAcc);
                for(const [product, index] of ordersAccEntries) {
                    if(index > deleteIndex) {
                        this.ordersAcc[product]--;
                    }
                }
            }
        },
        getOrdersAsArray: function()
        {
            return Object.keys(this.orders);
        },
    },
    mounted: function()
    {
        this.$root.$on('addProductToOrder', (product) => {
            if(this.ordersAcc[product] === undefined) {
                this.ordersAcc[product] = this.orders.length;
                this.orders.push(new Order(product));
            } else {
                this.changeQuantity(this.orders[this.ordersAcc[product]], 1);
            }
        })
    },
    created: function()
    {
        this.orders = [];
    },
    props: {
        linkOrderEndAction: String,
    },
    template: `
        <ul v-if="orders.length !== 0" class="list-group">
            <li v-for="order in orders" class="list-group-item">
                {{ order.name }}
                <button class="btn" @click="changeQuantity(order, -1);">-</button>
                {{ order.quantity }}
                <button class="btn" @click="changeQuantity(order, 1);">+</button>
            </li>
            <li class="list-group-item" v-html="linkOrderEndAction"></li>
        </ul>
    `
};

new Vue({
    el: '#vueOrderProducts',
    components: {
        'order-list': OrderList,
    },
});