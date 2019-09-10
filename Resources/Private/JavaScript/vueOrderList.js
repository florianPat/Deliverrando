(function(){
    //NOTE: Useless because does not work with ajax!
    if(document.getElementById('vueListOrder') !== null) {
        new Vue({
            el: '#vueListOrder',
            data: {
                finishedOrderTracker: [],
            },
            methods: {
                checkboxChange(orderUid, count, event) {
                    console.log('call');

                    if(event.target.checked) {
                        if(this.finishedOrderTracker[orderUid] !== undefined) {
                            --this.finishedOrderTracker[orderUid];
                            if(this.finishedOrderTracker[orderUid] === 0) {
                                //NOTE: Finished meal.
                            }
                        } else {
                            this.finishedOrderTracker[orderUid] = count - 1;
                        }
                    } else {
                        console.assert(this.finishedOrderTracker[orderUid] !== null, 'Needs to be defined!');

                        ++this.finishedOrderTracker[orderUid];
                    }
                },
            }
        });
    }
})();