let baseAPIURL = 'http://lampstudio.local/api/';
let animePlayerUrl = 'http://lampstudio.local/anime/';

window.MainComponent = function () {
    this.isLoadSerials = false;

    this.serialsContainer = $('#anime-section');
    this.serialsEmptyContainer = $('#serials-empty-container');
    this.filterContainer = $('#filter-container')
    this.page = 1;

    this.filter = {};

    this.init();
}

window.MainComponent.prototype = {
    init: function () {
        $(this.filterContainer).find('select').on('change', $.proxy(this.onFilterChange, this));
    },
    loadSerials: function () {
        if (this.emptyResponse) {
            return;
        }

        this.isLoadSerials = true;
        console.log('Отправляем запрос, страничка ' + this.page);
        $.ajax({
            type: "GET",
            url: baseAPIURL + 'serial/',
            data: {
                page: 1,
                filter: this.filter,
                sortField: 'views|DESC'
            },
            success: function (data) {
                if (data.data.length === 0) {
                    MainComponentApp.serialsEmptyContainer.show();
                } else if (data.data.length > 0) {
                    MainComponentApp.serialsEmptyContainer.hide();
                    data.data.forEach(function (element) {
                        let preparedNode = MainComponentApp.prepareSerialNode(element);
                        MainComponentApp.serialsContainer.append(preparedNode);
                    });
                }
                MainComponentApp.isLoadSerials = false;
            },
            error: function () {
                $.toast({
                    text: "Возникла ошибка при отправке запроса. \n Попробуйте позже",
                    bgColor: '#c0392b',              // Background color for toast
                    textColor: '#bdc3c7',            // text color
                    allowToastClose: true,       // Show the close button or not
                    position: 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    },

    onFilterChange: function () {
        this.filter = {};
        this.serialsContainer.empty();
        this.filterContainer.find('select').each(function () {
            if ($(this).val() === null) {
                return;
            }
            let propName = $(this).data('name');
            let propValue = $(this).val();
            if (propValue === 'empty') {
                return;
            }
            MainComponentApp.filter[propName] = propValue;
        });
        this.loadSerials();
    },

    prepareSerialNode: function (element) {
        let categories = element.categories.join(', ');

        return '<div class="anime-list__block__section__item">\n' +
            '                                <a href="' + animePlayerUrl + element.id + '">\n' +
            '                                    <img src="' + element.posterURL + '" class="anime-list__block__section__item__image">\n' +
            '                                </a>\n' +
            '                                <div class="anime-list__block__section__item__detail">\n' +
            '                                    <div class="anime-list__block__section__item__detail__header">\n' +
            '                                        <h2><a href="' + animePlayerUrl + element.id + '">' + element.name + '</a>\n' +
            '                                        </h2>\n' +
            '                                        <h2>\n' +
            '                                            <a href="' + animePlayerUrl + element.id + '">' + element.nameOrig + '</a>\n' +
            '                                        </h2>\n' +
            '                                    </div>\n' +
            '                                    <div class="anime-list__block__section__item__detail__genre">\n' +
            '                                        <h3>ЖАНРЫ:\n' +
            '                                            ' + categories + '\n' +
            '                                        </h3>\n' +
            '                                    </div>\n' +
            '                                    <div class="anime-list__block__section__item__detail__description">\n' +
            '                                        <h3>' + element.shortDescription + '</h3>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>'

    }
}
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
        for (let i = 1; i < 11; i++) {
            $('#rating-star-' + i).removeClass('full-star');
        }

        for (let i = 1; i < rating; i++) {
            $('#rating-star-' + i).addClass('full-star');
        }
    },

    outRating: function () {
        for (let i = Math.round(this.initRating); i < 11; i++) {
            $('#rating-star-' + i).removeClass('full-star');
        }
        for (let i = 1; i < this.initRating+1; i++) {
            $('#rating-star-' + i).addClass('full-star');
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
window.SerialList = function () {
    this.isLoadSerials = false;
    this.emptyResponse = false;

    this.serialsContainer = $('#anime-section');
    this.serialsEmptyContainer = $('#serials-empty-container');
    this.selectSort = $('#sort');
    this.filterContainer = $('#filter-container')
    this.page = 2;

    this.filter = {};

    this.init();
}

window.SerialList.prototype = {
    init: function () {
        $(window).on('scroll', $.proxy(this.onScroll, this));
        this.selectSort.on('change', $.proxy(this.onSortChange, this));
        $(this.filterContainer).find('select').on('change', $.proxy(this.onFilterChange, this));
    },

    onScroll: function () {
        if ((window.scrollY + window.innerHeight) > this.serialsContainer[0].getBoundingClientRect().bottom && !this.isLoadSerials) {
            this.loadSerials();
        }
    },

    loadSerials: function () {
        if (this.emptyResponse) {
            return;
        }

        this.isLoadSerials = true;
        console.log('Отправляем запрос, страничка ' + this.page);
        $.ajax({
            type: "GET",
            url: baseAPIURL + 'serial/',
            data: {
                page: this.page++,
                sortField: this.selectSort.val(),
                filter: this.filter
            },
            success: function (data) {
                if (data.data.length === 0) {
                    SerialsList.emptyResponse = true;

                    if (SerialsList.page === 2) {
                        SerialsList.serialsEmptyContainer.show();
                    }
                } else if (data.data.length > 0) {
                    SerialsList.serialsEmptyContainer.hide();
                    console.log('okay');
                    data.data.forEach(function (element) {
                        let preparedNode = SerialsList.prepareSerialNode(element);
                        SerialsList.serialsContainer.append(preparedNode);
                    });
                }
                SerialsList.isLoadSerials = false;
            },
            error: function () {
                $.toast({
                    text : "Возникла ошибка при отправке запроса. \n Попробуйте позже",
                    bgColor : '#c0392b',              // Background color for toast
                    textColor : '#bdc3c7',            // text color
                    allowToastClose : true,       // Show the close button or not
                    position : 'bottom-right',       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
                    icon: 'error'
                })
            }
        });
    },

    onSortChange: function () {
        this.page = 1;
        this.emptyResponse = false;
        this.serialsContainer.empty();
        this.loadSerials();
    },

    onFilterChange: function () {
        this.filter = {};
        this.page = 1;
        this.emptyResponse = false;
        this.serialsContainer.empty();
        this.filterContainer.find('select').each(function () {
            if ($(this).val() === null) {
                return;
            }
            let propName = $(this).data('name');
            let propValue = $(this).val();
            if (propValue === 'empty') {
                return;
            }
            SerialsList.filter[propName] = propValue;
        });
        this.loadSerials();
        console.log(this.filter);
    },

    prepareSerialNode: function (element) {
        let categories = element.categories.join(', ');

        return '<div class="anime-item">\n' +
            '                        <div class="anime-item__poster">\n' +
            '                            <a href="' + animePlayerUrl + element.id + '"><img src="' + element.posterURL + '"></a>\n' +
            '                            <div class="rate-flag">\n' +
            '                                <div class="rate-flag__inner">\n' +
            '                                    <div class="full-star blue-svg"></div>\n' +
            '                                    <div class="rate-flag__text">' + element.averageRating + '</div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <div class="anime-item__detail">\n' +
            '                            <h2 class="anime-item__header"><a href="' + animePlayerUrl + element.id + '">' + element.name + '</a></h2>\n' +
            '                            <p><a href="' + animePlayerUrl + element.id + '">' + element.nameOrig + '</a></p>\n' +
            '                            <div class="anime-item__info">\n' +
            '                                <h2 class="anime-item__main-info">' + element.type + ' / ' + element.year + '\n' +
            '                                    / ' + categories + '</h2>\n' +
            '                            </div>\n' +
            '                            <div class="anime-item__description">\n' +
            '                                ' + element.shortDescription + '\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                    </div>'
    }
}