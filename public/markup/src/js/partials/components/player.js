window.PlayerComponent = function (initRating, serialId) {
    this.initRating = initRating;
    this.serialId = serialId;

    this.ratingDom = $("#rating-wrap");

    this.init();
}

window.PlayerComponent.prototype = {
    init: function () {
        this.bindRating();
        console.log(this.initRating);
    },

    bindRating: function () {
        this.ratingDom.children().on('click', function () {
            let rating = $(this).data('rating');
            Player.setRating(rating);
        });
        this.ratingDom.children().on('mouseover', function () {
            let rating = $(this).data('rating');
            Player.overRating(rating);
        });
        this.ratingDom.children().on('mouseout', function () {
            Player.outRating();
        });
    },

    setRating: function (rating) {
        $.ajax({
            type: "POST",
            url: baseAPIURL + 'rating/',
            data: {
                serialId: this.serialId,
                rating: rating
            },
            dataType: 'json',
            success: function (data) {
                $.toast({
                    text : "Рейтинг успешно обновлен",
                    bgColor : '#27ae60',              // Background color for toast
                    textColor : '#ecf0f1',            // text color
                    allowToastClose : true,       // Show the close button or not
                    position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'success'
                })
            },
            error: function () {
                $.toast({
                    text : "Возникла ошибка при добавлении рейтинга. \n Попробуйте позже",
                    bgColor : '#c0392b',              // Background color for toast
                    textColor : '#bdc3c7',            // text color
                    allowToastClose : true,       // Show the close button or not
                    position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    },

    overRating: function (rating) {
        for (let i = 1; i < 10; i++) {
            $('#rating-star-' + i).removeClass('full-star');
        }

        for (let i = 1; i < rating; i++) {
            $('#rating-star-' + i).addClass('full-star');
        }
    },

    outRating: function () {
        for (let i = 1; i < this.initRating; i++) {
            $('#rating-star-' + i).addClass('full-star');
        }
        for (let i = Math.round(this.initRating); i < 10; i++) {
            $('#rating-star-' + i).removeClass('full-star');
        }
    }
}

// const RatingApp = Vue.createApp({});
// RatingApp.component('rating-component', {
//     props: ['defrating'],
//     data() {
//         return {
//             sendRatingResponse: false,
//             rate: 0,
//             ratings: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
//             isHover: false
//         }
//     },
//     mounted() {
//         console.log('Init ' + this.defrating)
//     },
//     methods: {
//         setRating() {
//
//         },
//         hoverRating(rate) {
//             this.rate = rate
//             this.isHover = true
//             console.log(rate)
//         },
//         outRating() {
//             this.isHover = false
//             this.rate = undefined
//         },
//     },
//     template: '<label class="detail-info__rating__stars__star" v-on:mouseover="hoverRating(rating)" ' +
//         'v-on:mouseout="outRating()"' +
//         'v-bind:class="{\'full-star\': rate >= rating || (defrating >= rating && !isHover)}" ' +
//         'v-for="rating in ratings"></label>'
// });
//
// RatingApp.mount('#rating-wrap');